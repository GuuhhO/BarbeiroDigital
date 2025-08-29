<?php

class AgendamentoModel
{
    public function obterAgendamentosPendentes()
    {
        global $db;

        // $sql = $db->prepare("
        //     SELECT id, telefone, cliente, dia, horario
        //     FROM api.agendamentos
        //     WHERE lembrete_enviado = false
        //     AND (dia || ' ' || horario)::timestamp <= NOW() + INTERVAL '1 hour';
        // ");

        $sql = $db->prepare("
            SELECT *
            FROM api.agendamentos
            WHERE id = 26
        ");

        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function marcarLembreteEnviado($id)
    {
        global $db;
        $stmt = $db->prepare("UPDATE api.agendamentos SET lembrete_enviado = true WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function obterNomeServico($servico_id)
    {
        global $db;
        $stmt = $db->prepare("SELECT servico FROM seg.servicos WHERE id = ?");
        $stmt->execute([$servico_id]);
        $nome = $stmt->fetchColumn(); // retorna diretamente o valor da coluna 'servico'
        return $nome ?: 'Serviço não encontrado';
    }

}
