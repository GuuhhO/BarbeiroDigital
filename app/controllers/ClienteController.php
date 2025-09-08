<?php
require_once __DIR__ . '/../controllers/LembreteController.php';

class ClienteController
{
    public function verificarCliente()
    {
      global $db;

      $telefone = $_POST['telefone'] ?? '';

      if (empty($telefone)) {
         echo json_encode(["erro" => "Telefone inválido"]);
         return;
      }

      $obterAgendamentos = $db->prepare("SELECT * FROM api.agendamentos WHERE telefone = ?");
      $obterAgendamentos->execute([$telefone]);
      $agendamentos = $obterAgendamentos->fetchAll(PDO::FETCH_ASSOC);

      if (empty($agendamentos)) {
         echo json_encode(["erro" => "Nenhum agendamento encontrado."]);
         return;
      }

      echo json_encode(["sucesso" => true, "dados" => $agendamentos]);
    }

    public function index()
    {
      global $db;

      $telefone = $_POST['telefone'] ?? '';
      $agendamentos = [];

      if ($telefone) {
         $obterAgendamentos = $db->prepare("SELECT * FROM api.agendamentos WHERE telefone = ?");
         $obterAgendamentos->execute([$telefone]);
         $agendamentos = $obterAgendamentos->fetchAll(PDO::FETCH_ASSOC);
      }

      $servicos = [
         1 => 'Corte',
         2 => 'Corte e barba',
         3 => 'Barba',
         4 => 'Sobrancelha',
         5 => 'Pezinho'
      ];

      view('cliente/index', ['agendamentos' => $agendamentos, 'servicos' => $servicos]);
    }

   public function excluirAgendamento()
   {
      global $db;

      $lembreteController = new LembreteController();
      $lembreteStatus = false;

      $agendamentoId = $_POST['agendamento_id'];

      if (empty($agendamentoId))
      {
         echo json_encode(["erro" => "Nenhum agendamento encontrado."]);
         return;
      }

      $dadosCliente = $this->obterDadosCliente();

      $excluirAgendamentoDb = $db->prepare("DELETE FROM api.agendamentos WHERE id = ?");
      $excluirAgendamentoDb->execute([$agendamentoId]);

      if (!$excluirAgendamentoDb)
      {
         echo json_encode(["erro" => "Não foi possível cancelar o agendamento."]);
         return;
      }

      try {
         $lembreteStatus = $lembreteController->avisarCancelamentoHorario($dadosCliente);
      } catch (Exception $e) {
         error_log("Erro ao enviar lembrete: " . $e->getMessage());
      }

      echo json_encode([
         'sucesso' => true,
         'lembrete' => $lembreteStatus ? true : false
      ]);
   }

   public function obterDadosCliente()
   {
      global $db;

      $agendamentoId = $_POST['agendamento_id'];

      $dadosCliente = $db->prepare("SELECT * FROM api.agendamentos WHERE id = ?");
      $dadosCliente->execute([$agendamentoId]);

      return $dadosCliente->fetch(PDO::FETCH_ASSOC);
   }
}
