<?php

require_once __DIR__ . '/../models/AgendamentoModel.php';

class LembreteController
{
    private $model;

    public function __construct()
    {
        $this->model = new AgendamentoModel();
    }

    public function enviar()
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



}
