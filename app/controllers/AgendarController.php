<?php

require_once __DIR__ . '/../models/ServicoModel.php';
require_once __DIR__ . '/../models/ExpedienteModel.php';

class AgendarController
{
   public function index()
   {
      $servicoModel = new ServicoModel();

      $expedienteModel = new ExpedienteModel();

      $servicos = $servicoModel->obterServicosAtivos();
      $diasAtivos = $expedienteModel->obterDiasAtivos();
      view('agendar/index', compact('servicos', 'diasAtivos'));
   }

   private function gerarHorariosPadrao()
   {
      global $db;

      $obterExpediente = $db->query("SELECT * FROM seg.expedientes LIMIT 1");
      $expediente = $obterExpediente->fetch(PDO::FETCH_ASSOC);

      if (!$expediente) return [];

      $expedientes = [
         ['inicio' => $expediente['inicio'], 'fim' => $expediente['almoco']],
         ['inicio' => $expediente['retorno'], 'fim' => $expediente['termino']]
      ];

      $horarios = [];

      foreach ($expedientes as $turno) {
         $inicio = new DateTime($turno['inicio']);
         $fim = new DateTime($turno['fim']);

         while ($inicio < $fim) {
            $horario = $inicio->format('H:i');
            if (empty($horarios) || end($horarios) < $horario) {
               $horarios[] = $horario;
            }
            $inicio->modify('+15 minutes');
         }
      }
      return $horarios;
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

      $dia = $_POST['dia'] ?? null;
      $servicoId = $_POST['servico_id'] ?? null;

      if (!$dia || !$servicoId) {
         echo json_encode(["erro" => "Parâmetros inválidos"]);
         return;
      }

      $horarios = $this->gerarHorariosPadrao();

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
      $obterAgendados->execute(['data' => $dia]);
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
      $query = $db->prepare("SELECT duracao FROM seg.servicos WHERE id = ?");
      $query->execute([$servicoId]);
      $duracao = $query->fetchColumn();

      if (!$duracao) {
         echo json_encode(['erro' => 'Serviço inválido.']);
         return;
      }

      // Inserir agendamento
      $insert = $db->prepare("
         INSERT INTO api.agendamentos (cliente, telefone, servico_id, dia, horario, duracao)
         VALUES (:cliente, :telefone, :servico_id, :dia, :horario, :duracao)
      ");

      $insert->execute([
         'cliente' => $cliente,
         'telefone' => $telefone,
         'servico_id' => $servicoId,
         'dia' => $dia,
         'horario' => $horario,
         'duracao' => $duracao
      ]);

      echo json_encode(['sucesso' => true]);
   }

   public function meusAgendamentos()
   {
      global $db;
      
   }

}