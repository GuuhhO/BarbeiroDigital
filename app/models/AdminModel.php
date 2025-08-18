<?php

class AdminModel
{
    public function obterAgendamentos()
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM api.agendamentos ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterClientes()
    {
        global $db;

        $stmt = $db->prepare("SELECT DISTINCT(cliente), telefone FROM api.agendamentos ORDER BY cliente ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterServicos()
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM seg.servicos ORDER BY servico ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterExpedientes()
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM seg.expedientes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
