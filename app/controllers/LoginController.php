<?php

class LoginController
{
    public function index()
    {
        view('login/index');
    }
    public function loginForm()
    {
        $this->render('login');
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && $userModel->verifyPassword($password, $user['password'])) {
            Session::set('user', [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name']
            ]);
            header('Location: /dashboard');
            exit;
        }

        $this->render('login', ['error' => 'Credenciais inválidas.']);
    }

    public function logout()
    {
        Session::destroy();
        header('Location: /login');
        exit;
    }

}