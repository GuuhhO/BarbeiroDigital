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

    public function converterTelefone($telefone)
    {
        $telefone = preg_replace('/\D/', '', $telefone);

        // Adiciona código do país (55) se ainda não estiver presente
        if (substr($telefone, 0, 2) != '55') {
            $telefone = '55' . $telefone;
        }

        return $telefone;
    }

    public function enviarAvisoAgendado()
    {
        global $db;

        $cliente = $_POST['cliente'];
        $telefone = $_POST['telefone'];
        $servico_id = $_POST['servico_id'];
        $dia = $_POST['dia'];
        $horario = $_POST['horario'];

        $telefoneFormatado = $this->converterTelefone($telefone);

        $nomeServico = $this->model->obterNomeServico($servico_id);

        $msg = "💈 Olá {$cliente}, você acabou de agendar um atendimento na *Barbearia Soares!*\n\n" .
                "⏰ *Dia:* " . date('d/m/Y', strtotime($dia)) . " às {$horario}\n" .
                "✂ *Serviço:* {$nomeServico}\n" .
                "📍 *Endereço:* Rua das Tulipas, 449, Eldorado/São Pedro, Itabira/MG\n" .
                "👇 *Clique no link abaixo para ver no mapa:* \n" .
                "http://bit.ly/4p8s4Rt \n\n" .
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
