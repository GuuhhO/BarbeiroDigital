<?php

require_once __DIR__ . '/../models/AgendamentoModel.php';

class LembreteController
{
    private $model;

    public function __construct()
    {
        $this->model = new AgendamentoModel();
    }

    public function enviarLembreteAgendamento()
    {
        $agendamentos = $this->model->obterAgendamentosPendentes();        

        foreach ($agendamentos as $agendamento) {
            $nomeServico = $this->model->obterNomeServico($agendamento['servico_id']);

            $msg = "⚠️ Olá *{$agendamento['cliente']}*, este é um lembrete do seu horário daqui uma hora na *Barbearia Soares*\n\n" .
                "⏰ *Dia:* " . date('d/m/Y', strtotime($agendamento['dia'])) . " às {$agendamento['horario']}\n" .
                "💈 *Serviço:* {$nomeServico}\n" .
                "📍 *Endereço:* Rua das Tulipas, 449, Eldorado/São Pedro, Itabira/MG\n" .
                "👇 *Clique no link abaixo para ver no mapa:* \n" .
                "https://maps.app.goo.gl/r3i8BQ6SpYBrZ5i96 \n\n" .
                "*Não se esqueça de levar seu cartão de fidelidade!*";

            // Corrigido: agora a variável correta
            $telefone = $agendamento['telefone'];

            // Monta URL da API Node
            $url = "http://localhost:3000/send?phone=" . urlencode($telefone) . "&msg=" . urlencode($msg);

            // Inicializa cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Verifica resposta
            if ($response === false || $httpcode != 200) {
                error_log("❌ Erro ao enviar mensagem para {$telefone}");
                continue; // pula para o próximo
            } else {
                echo "✅ Mensagem enviada para {$telefone}\n";
                $this->model->marcarLembreteEnviado($agendamento['id']);
            }
        }
    }

    public function formatarTelefone($telefone)
    {
        if (!$telefone) {
            return null;
        }

        // Remove tudo que não for número
        $telefone = preg_replace('/\D/', '', $telefone);

        // Se já vier com 55, corta pra analisar só o número nacional
        if (substr($telefone, 0, 2) === '55') {
            $telefone = substr($telefone, 2);
        }

        // DDD e resto
        $ddd = substr($telefone, 0, 2);
        $resto = substr($telefone, 2);

        // DDDs que sempre aceitam o 9
        $ddds_com_9 = array_merge(range(11, 19), [21, 22, 24, 27, 28]);

        // Se não estiver na lista e tiver 9 dígitos começando com 9 → remove
        if (!in_array((int)$ddd, $ddds_com_9)) {
            if (strlen($resto) === 9 && $resto[0] === '9') {
                $resto = substr($resto, 1);
            }
        }

        $telefoneNormalizado = $ddd . $resto;

        // Validação: precisa ter 10 ou 11 dígitos
        if (strlen($telefoneNormalizado) < 10 || strlen($telefoneNormalizado) > 11) {
            return null;
        }

        // Adiciona código do país (55)
        return '55' . $telefoneNormalizado;
    }

    public function enviarAvisoAgendado()
    {
        global $db;

        $cliente = $_POST['cliente'];
        $telefone = $_POST['telefone'];
        $servico_id = $_POST['servico_id'];
        $dia = $_POST['dia'];
        $horario = $_POST['horario'];

        $telefoneFormatado = $this->formatarTelefone($telefone);

        $nomeServico = $this->model->obterNomeServico($servico_id);

        $msg = "💈 Olá {$cliente}, você acabou de agendar um atendimento na *Barbearia Soares!*\n\n" .
                "⏰ *Dia:* " . date('d/m/Y', strtotime($dia)) . " às {$horario}\n" .
                "✂ *Serviço:* {$nomeServico}\n" .
                "📍 *Endereço:* Rua das Tulipas, 449, Eldorado/São Pedro, Itabira/MG\n" .
                "https://shre.ink/S02k \n\n" .
                "⚠️ *Não se esqueça de levar seu cartão de fidelidade!*";

        $url = "http://localhost:3000/send?phone=" . urlencode($telefoneFormatado) . "&msg=" . urlencode($msg);

        // Inicializa cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false || $httpcode != 200) {
            error_log("Erro ao enviar mensagem para {$telefoneFormatado}");
            return false;
        }

        return true;
    }
}
