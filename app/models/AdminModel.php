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

    public function obterContagemAgendamentos()
    {
        global $db;

        $stmt = $db->prepare("SELECT COUNT(*) FROM api.agendamentos");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterContagemAgendamentosHoje()
    {
        global $db;

        $dia = date('Y-m-d');
        $horaAtual = date('H:i:s'); ;
        $stmt = $db->prepare("SELECT COUNT(*) FROM api.agendamentos WHERE dia = ? AND horario > ?");
        $stmt->execute([$dia, $horaAtual]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterContagemAgendamentosAmanha()
    {
        global $db;

        $amanha = date('Y-m-d', strtotime('+1 day'));
        $stmt = $db->prepare("SELECT COUNT(*) FROM api.agendamentos WHERE dia = ?");
        $stmt->execute([$amanha]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterContagemAgendamentosMes()
    {
        global $db;

        $inicioMes = date('Y-m-01'); 
        $fimMes = date('Y-m-t');

        $stmt = $db->prepare("SELECT COUNT(*) FROM api.agendamentos WHERE dia BETWEEN :inicio AND :fim");
        $stmt->execute([$inicioMes, $fimMes]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterContagemAgendamentosHojeTotal()
    {
        global $db;

        $dia = date('Y-m-d');
        $stmt = $db->prepare("SELECT COUNT(*) FROM api.agendamentos WHERE dia = ?");
        $stmt->execute([$dia]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterContagemAgendamentosAtendidos()
    {
        global $db;

        $stmt = $db->prepare("SELECT COUNT(*) FROM api.agendamentos WHERE atendido = true");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterFaturamentoHoje()
    {
        global $db;

        $dia = date('Y-m-d');

        $stmt = $db->prepare("
            SELECT COALESCE(SUM(preco), 0) AS total 
            FROM api.agendamentos 
            WHERE dia = ?");
        $stmt->execute([$dia]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterFaturamentoMensal()
    {
        global $db;

        $inicioMes = date('Y-m-01'); 
        $fimMes = date('Y-m-t');

        $stmt = $db->prepare("
            SELECT COALESCE(SUM(preco), 0) AS total 
            FROM api.agendamentos 
            WHERE dia BETWEEN :inicio AND :fim
        ");
        $stmt->execute([$inicioMes, $fimMes]);
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
