<?php

class LembreteModel
{
    public function verificarAtendimentosAmanha()
    {
        global $db;

        $amanha = date('Y-m-d', strtotime('+1 day'));

        $agendamentosAmanhaSql = $db->prepare("SELECT * FROM api.agendamentos WHERE dia = :data");
        $agendamentosAmanhaSql->execute([':data' => $amanha]);
        return $agendamentosAmanhaSql->fetchAll(PDO::FETCH_ASSOC);
    }
}