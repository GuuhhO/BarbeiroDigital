<?php

class AgendamentoModel
{
    public function obterAgendamentos($limite = 10, $offset = 0)
    {
        global $db;

        $stmt = $db->prepare("SELECT a.*, s.servico AS servico_nome
            FROM api.agendamentos a
            JOIN seg.servicos s ON s.id = CAST(a.servico_id AS INTEGER)
            ORDER BY a.id DESC
            LIMIT :limite OFFSET :offset");

        // bindParam exige tipo inteiro
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarAgendamentos()
    {
        global $db;

        $stmt = $db->prepare("SELECT COUNT(*) AS total FROM api.agendamentos");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

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
