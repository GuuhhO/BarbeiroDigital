<?php

require_once __DIR__ . '/../models/AdminModel.php';

class AdminController
{
    public function index()
    {
        view('admin/index');
    }

    public function painel()
    {
        $modelo = new AdminModel();

        $agendamentos = $modelo->obterAgendamentos();
        $clientes = $modelo->obterClientes();
        view('admin/painel', compact('agendamentos', 'clientes'));
    }

    public function cadastrar()
    {
        view('admin/cadastrar');
    }

    public function configuracoes()
    {
        $modelo = new AdminModel();

        $servicos = $modelo->obterServicos();
        view('admin/configuracoes', compact('servicos'));
    }
    

    public function logar()
    {
        global $db;
        session_start();

        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if (empty($usuario) || empty($senha)) {
            echo json_encode(["erro" => "Preencha usuário e senha"]);
            return;
        }

        $verificarUsuario = $db->prepare("SELECT * FROM seg.usuarios WHERE usuario = ?");
        $verificarUsuario->execute([$usuario]);

        $usuarioData = $verificarUsuario->fetch(PDO::FETCH_ASSOC);

        if (!$usuarioData) {
            echo json_encode(["erro" => "Usuário não encontrado"]);
            return;
        }

        if (!password_verify($senha, $usuarioData['senha'])) {
            echo json_encode(["erro" => "Usuário ou senha incorretos"]);
            return;
        }

        // Autenticação OK
        $_SESSION['usuario'] = $usuarioData['usuario'];
        echo json_encode(["sucesso" => true]);
    }

    public function cadastrarAdmin()
    {
        global $db;

        header('Content-Type: application/json');

        $usuario = $_POST['usuario'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if (empty($usuario) || empty($senha) || empty($email)) {
            echo json_encode(["erro" => "Preencha todos os campos"]);
            return;
        }

        $verificarUsuario = $db->prepare("SELECT * FROM seg.usuarios WHERE usuario = ?");
        $verificarUsuario->execute([$usuario]);

        if ($verificarUsuario->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode(["erro" => "Usuário já cadastrado"]);
            return;
        }

        $verificarEmail = $db->prepare("SELECT * FROM seg.usuarios WHERE email = ?");
        $verificarEmail->execute([$email]);
        if ($verificarEmail->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode(["erro" => "E-mail já cadastrado"]);
            return;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $cadastrarDb = $db->prepare("INSERT INTO seg.usuarios (usuario, email, senha) VALUES (?, ?, ?)");
        $cadastrar = $cadastrarDb->execute([$usuario, $email, $senhaHash]);

        if ($cadastrar) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Erro ao cadastrar usuário"]);
        }
    }

    public function obterAgendamentos()
    {
        global $db;

        $obterAgendamentoSql = $db->prepare("SELECT * FROM api.agendamentos ORDER BY id DESC");
        $obterAgendamentoSql->execute();

        return $obterAgendamentoSql->fetchAll(PDO::FETCH_ASSOC); // retorna os dados como array associativo
    }

    public function obterClientes()
    {
        global $db;

        $stmt = $db->prepare("SELECT DISTINCT(cliente) FROM api.agendamentos ORDER BY cliente ASC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removerAgendamento()
    {
        global $db;

        $agendamento_id = $_POST['agendamento_id'];

        $removerAgendamentoSql = $db->prepare("DELETE FROM api.agendamentos WHERE id = ?");
        $removerAgendamento = $removerAgendamentoSql->execute([$agendamento_id]);

        if ($removerAgendamento) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Erro ao cancelar agendamento"]);
        }
        
    }

    public function atualizarServico()
    {
        global $db;

        $servico_id = $_POST['servico_id'];
        $servico = $_POST['servico'];
        $duracao = $_POST['duracao'];
        $ativo = $_POST['ativo'];
        $preco = $_POST['preco'];

        if (empty($servico) || empty($duracao) || empty($ativo) || empty($preco))
        {
            echo json_encode(["erro" => "Preencha todos os campos"]);
            return;
        }

        try {
            $atualizarServicoSql= $db->prepare("
                UPDATE seg.servicos
                SET servico = ?, duracao = ?, ativo = ?, preco = ?
                WHERE id = ?
            ");

            $atualizarServico = $atualizarServicoSql->execute([
                $servico,
                $duracao,
                $ativo,
                $preco,
                $servico_id
            ]);

            if ($atualizarServico) {
                echo json_encode(["sucesso" => "Serviço atualizado com sucesso"]);
            } else {
                echo json_encode(["erro" => "Erro ao atualizar serviço"]);
            }
        } catch (PDOException $e) {
        echo json_encode(["erro" => "Erro no banco de dados: " . $e->getMessage()]);
        }
    }
}