<?php

require_once __DIR__ . '/../models/ServicoModel.php';
require_once __DIR__ . '/../models/ExpedienteModel.php';
require_once __DIR__ . '/../models/BarbeiroModel.php';
require_once __DIR__ . '/../controllers/LembreteController.php';

use App\Services\WhatsAppService;

class AgendarController
{
    public function index()
    {
        $servicoModel = new ServicoModel();
        $expedienteModel = new ExpedienteModel();
        $barbeiroModel = new BarbeiroModel();

        $servicos = $servicoModel->obterServicosAtivos();
        $diasAtivos = $expedienteModel->obterDiasAtivos();
        $barbeirosAtivos = $barbeiroModel->obterBarbeirosAtivos();
        view('agendar/index', compact('servicos', 'diasAtivos', 'barbeirosAtivos'));
    }

    public function gerarHorariosPadrao()
    {
        global $db;

        $obterExpediente = $db->query("SELECT * FROM seg.expedientes");
        $expedientes = $obterExpediente->fetchAll(PDO::FETCH_ASSOC);

        if (!$expedientes) return [];

        $horariosPorDia = [];

        foreach ($expedientes as $expediente) {
            // garante que os campos existem
            $inicio   = $expediente['inicio']   ?? null;
            $almoco   = $expediente['almoco']   ?? null;
            $retorno  = $expediente['retorno']  ?? null;
            $termino  = $expediente['termino']  ?? null;

            if (!$inicio || !$almoco || !$retorno || !$termino) {
                continue; // pula se o expediente não estiver completo
            }

            $turnos = [
                ['inicio' => $inicio, 'fim' => $almoco],
                ['inicio' => $retorno, 'fim' => $termino]
            ];

            $horarios = [];

            foreach ($turnos as $turno) {
                try {
                    $horaInicio = new DateTime((string)$turno['inicio']);
                    $horaFim    = new DateTime((string)$turno['fim']);
                } catch (Exception $e) {
                    continue; // se não for string válida, ignora
                }

                while ($horaInicio < $horaFim) {
                    $horario = $horaInicio->format('H:i');
                    if (empty($horarios) || end($horarios) < $horario) {
                        $horarios[] = $horario;
                    }
                    $horaInicio->modify('+15 minutes'); // intervalo
                }
            }

            // associa o expediente ao nome do dia
            $horariosPorDia[$expediente['dia']] = $horarios;
        }

        return $horariosPorDia;
    }

    public function horarios()
    {
        $horarios = $this->gerarHorariosPadrao();
        echo json_encode($horarios);
    }

    public function obterDiasAtivos()
    {
        global $db;

        $dias = [
            'Domingo' => 0,
            'Segunda' => 1,
            'Terça'   => 2,
            'Quarta'  => 3,
            'Quinta'  => 4,
            'Sexta'   => 5,
            'Sábado'  => 6
        ];

        $diasAtivosSql = $db->prepare("SELECT dia FROM seg.expedientes WHERE ativo = true");
        $diasAtivosSql->execute();
        $diasAtivosRes = $diasAtivosSql->fetchAll(PDO::FETCH_COLUMN);

        $diasAtivos = [];
        foreach ($diasAtivosRes as $dia) {
            if (isset($dias[$dia])) {
                $diasAtivos[] = $dias[$dia];
            }
        }

        return $diasAtivos;
    }

    public function obterDiasAtivosAjax()
    {
        $diasAtivos = $this->obterDiasAtivos();
        echo json_encode($diasAtivos);
        exit;
    }

    public function verificarHorariosDisponiveis()
    {
        global $db;

        $dia = $_POST['dia'] ?? null; // formato dd/mm/yyyy
        $servicoId = $_POST['servico_id'] ?? null;

        if (!$dia || !$servicoId) {
            echo json_encode(["erro" => "Parâmetros inválidos"]);
            return;
        }

        $dataObj = DateTime::createFromFormat('d/m/Y', $dia);
        if (!$dataObj) {
            echo json_encode(["erro" => "Data inválida"]);
            return;
        }

        $diasSemana = ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
        $nomeDia = $diasSemana[(int)$dataObj->format('w')]; // 0=domingo ... 6=sábado

        $horariosPorDia = $this->gerarHorariosPadrao();

        if (!isset($horariosPorDia[$nomeDia])) {
            echo json_encode([]); // dia sem expediente
            return;
        }

        $horarios = $horariosPorDia[$nomeDia];

        // Duração do serviço
        $obterServico = $db->prepare("SELECT duracao FROM seg.servicos WHERE id = ?");
        $obterServico->execute([$servicoId]);
        $duracao = $obterServico->fetchColumn();

        if (!$duracao) {
            echo json_encode(["erro" => "Serviço não encontrado"]);
            return;
        }

        list($h, $m) = explode(':', $duracao);
        $duracaoMin = ((int)$h * 60) + (int)$m;

        // Agendamentos do dia
        $obterAgendados = $db->prepare("SELECT horario, duracao FROM api.agendamentos WHERE dia = :data");
        $obterAgendados->execute(['data' => $dataObj->format('Y-m-d')]);
        $agendados = $obterAgendados->fetchAll(PDO::FETCH_ASSOC);

        $horariosOcupados = [];

        foreach ($agendados as $ag) {
            $inicioAg = new DateTime($ag['horario']);
            list($h, $m) = explode(':', $ag['duracao']);
            $durAgMin = ((int)$h * 60) + (int)$m;

            for ($i = 0; $i < $durAgMin / 15; $i++) {
                $horariosOcupados[] = $inicioAg->format('H:i');
                $inicioAg->modify('+15 minutes');
            }
        }

        $horariosOcupados = array_unique($horariosOcupados);

        $horariosDisponiveis = $horarios;

        foreach ($horarios as $h) {
            $inicio = new DateTime($h);
            $fim = clone $inicio;
            $fim->modify("+$duracaoMin minutes");

            $intervaloLivre = true;
            $temp = clone $inicio;

            while ($temp < $fim) {
                if (in_array($temp->format('H:i'), $horariosOcupados)) {
                    $intervaloLivre = false;
                    break;
                }
                $temp->modify('+15 minutes');
            }

            if (!$intervaloLivre) {
                unset($horariosDisponiveis[array_search($h, $horariosDisponiveis)]);
            }
        }

        $horariosDisponiveis = array_values($horariosDisponiveis);

        echo json_encode($horariosDisponiveis);
    }

    public function agendarCliente()
    {
        global $db;

        $cliente = $_POST['cliente'] ?? null;
        $telefone = $_POST['telefone'] ?? null;
        $servicoId = $_POST['servico_id'] ?? null;
        $dia = $_POST['dia'] ?? null;
        $horario = $_POST['horario'] ?? null;

        if (!$cliente || !$telefone || !$servicoId || !$dia || !$horario) {
            echo json_encode(['erro' => 'Dados incompletos.']);
            return;
        }

        if ($dia) {
            // Converte dd/mm/yyyy para yyyy-mm-dd
            $dataObj = DateTime::createFromFormat('d/m/Y', $dia);
            if ($dataObj) {
            $dia = $dataObj->format('Y-m-d');
            } else {
            echo json_encode(['erro' => 'Data inválida.']);
            return;
            }
        }

        // Obter duração do serviço
        $obterDadosServico = $db->prepare("SELECT duracao, preco FROM seg.servicos WHERE id = ?");
        $obterDadosServico->execute([$servicoId]);
        $dadosServico = $obterDadosServico->fetchAll(PDO::FETCH_ASSOC);

        if (!$obterDadosServico) {
            echo json_encode(['erro' => 'Serviço inválido.']);
            return;
        }

        $insert = $db->prepare("
            INSERT INTO api.agendamentos (cliente, telefone, servico_id, dia, horario, duracao, preco)
            VALUES (:cliente, :telefone, :servico_id, :dia, :horario, :duracao, :preco)
        ");

        $insert->execute([
            'cliente' => $cliente,
            'telefone' => $telefone,
            'servico_id' => $servicoId,
            'dia' => $dia,
            'horario' => $horario,
            'duracao' => $dadosServico['0']['duracao'],
            'preco' => $dadosServico['0']['preco']
        ]);

        $lembreteController = new LembreteController();
        $lembreteStatus = false;

        try {
            $lembreteStatus = $lembreteController->enviarAvisoAgendado();
        } catch (Exception $e) {
            error_log("Erro ao enviar lembrete: " . $e->getMessage());
        }

        echo json_encode([
            'sucesso' => true,
            'lembrete' => $lembreteStatus ? true : false
        ]);
    }

    public function obterBarbeiroPorServicoService()
    {
        if (!isset($_POST['servico_id']) || empty($_POST['servico_id'])) {
            echo json_encode(['error' => 'Serviço não informado']);
            return;
        }

        $servico_id = $_POST['servico_id'];
        $barbeiroModel = new BarbeiroModel();
        $barbeiros = $barbeiroModel->obterBarbeirosAtivosServicos($servico_id);

        echo json_encode($barbeiros);
    }

    public function obterDadosGrafico()
    {
        global $db;
        $sql = "SELECT s.servico AS servico, COUNT(*) AS total
            FROM api.agendamentos a
            JOIN seg.servicos s ON CAST(a.servico_id AS INTEGER) = s.id
            GROUP BY s.servico
            ORDER BY total DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($dados);
    }
}