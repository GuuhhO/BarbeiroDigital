<?php

class ServicoModel
{
    public function obterServicos()
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM seg.servicos ORDER BY servico ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
