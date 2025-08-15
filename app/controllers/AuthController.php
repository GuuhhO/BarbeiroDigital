<?php

require_once __DIR__ . '/../models/UsuarioModel.php';

class AuthController
{
    public function index()
    {
        view('auth/index');
    }

    public function login()
    {
        view('auth/login');
    }

    public function loginForm()
    {
        $this->render('login');
    }

    public function verificarCredencial()
    {
        global $db;

        $login = trim($_POST['usuario']);
        $senha = $_POST['senha'];

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->buscarPorLogin($login);

        if ($usuario && $usuarioModel->verificarSenha($senha, $usuario['senha_hash'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            Session::set('user', [
                'id' => $usuario['id'],
                'email' => $usuario['email'],
                'name' => $usuario['usuario']
            ]);

            session_regenerate_id(true);

            echo json_encode(['sucesso' => true]);
            return;
        }

        echo json_encode(['sucesso' => false, 'mensagem' => 'Credenciais inválidas.']);
    }

    public function logout()
    {
        Session::destroy();
        header('Location: /login');
        exit;
    }

}