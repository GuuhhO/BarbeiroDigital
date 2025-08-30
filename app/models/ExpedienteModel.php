<?php

class ExpedienteModel
{
    public function obterExpedientes()
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM seg.expedientes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obterDiasAtivos()
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM seg.expedientes WHERE ativo = true");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}