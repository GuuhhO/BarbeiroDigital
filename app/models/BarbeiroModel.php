<?php

class BarbeiroModel
{
    public function obterBarbeiros()
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM seg.barbeiros");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterBarbeirosAtivos()
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM seg.barbeiros WHERE ativo = true ORDER BY nome ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterBarbeirosAtivosServicos($servico_id)
    {
        global $db;

        $sql = "SELECT id, nome 
                FROM seg.barbeiros 
                WHERE ativo = true 
                AND servicos_id ILIKE :servico
                ORDER BY nome ASC";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':servico', '%' . $servico_id . '%');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}