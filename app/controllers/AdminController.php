<?php

class AdminController
{
    public function index()
    {
        view('admin/index');
    }

    public function painel()
    {
        view('admin/painel');
    }

    public function cadastrar()
    {
        view('admin/cadastrar');
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

}