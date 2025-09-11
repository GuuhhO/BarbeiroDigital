<?php

class AgendamentoModel
{
    public function obterAgendamentos($limite = 10, $offset = 0, $nome = null, $telefone = null, $servico_id = null, $dia = null)
    {
        global $db;

        $sql = "SELECT a.*, s.servico AS servico_nome
                FROM api.agendamentos a
                JOIN seg.servicos s ON s.id = CAST(a.servico_id AS INTEGER)
                WHERE 1=1";

        $params = [];

        if (!empty($nome)) {
            $sql .= " AND a.cliente ILIKE :nome"; // ILIKE para case-insensitive no Postgres
            $params[':nome'] = "%$nome%";
        }

        if (!empty($telefone)) {
            $sql .= " AND a.telefone ILIKE :telefone";
            $params[':telefone'] = "%$telefone%";
        }

        if (!empty($servico_id)) {
            $sql .= " AND a.servico_id = :servico_id";
            $params[':servico_id'] = $servico_id;
        }

        if (!empty($dia)) {
            $sql .= " AND DATE(a.data_agendamento) = :dia";
            $params[':dia'] = $dia; // yyyy-mm-dd vindo do <input type="date">
        }

        $sql .= " ORDER BY a.id DESC LIMIT :limite OFFSET :offset";

        $stmt = $db->prepare($sql);

        // Bind dos filtros
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        // Bind da paginação
        $stmt->bindValue(':limite', (int) $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarAgendamentos($nome = null, $telefone = null, $servico_id = null, $dia = null)
    {
        global $db;

        $sql = "SELECT COUNT(*) as total
                FROM api.agendamentos a
                JOIN seg.servicos s ON s.id = CAST(a.servico_id AS INTEGER)
                WHERE 1=1";

        $params = [];

        if (!empty($nome)) {
            $sql .= " AND a.cliente ILIKE :nome";
            $params[':nome'] = "%$nome%";
        }

        if (!empty($telefone)) {
            $sql .= " AND a.telefone ILIKE :telefone";
            $params[':telefone'] = "%$telefone%";
        }

        if (!empty($servico_id)) {
            $sql .= " AND a.servico_id = :servico_id";
            $params[':servico_id'] = $servico_id;
        }

        if (!empty($dia)) {
            $sql .= " AND DATE(a.data_agendamento) = :dia";
            $params[':dia'] = $dia;
        }

        $stmt = $db->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        return (int) $stmt->fetchColumn();
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
