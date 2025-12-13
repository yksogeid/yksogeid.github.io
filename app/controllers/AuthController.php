<?php

class AuthController extends Controller
{
    public function login()
    {
        // If already logged in, redirect to home
        if (isset($_SESSION['auth_user']) && $_SESSION['auth_user'] === true) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
        unset($_SESSION['login_error']); // Clear error after displaying

        $this->view('auth/login', ['error' => $error]);
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';

            if ($password === 'navidad2025') {
                $_SESSION['auth_user'] = true;
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $_SESSION['login_error'] = '❌ Contraseña incorrecta. Intenta de nuevo.';
                header('Location: ' . BASE_URL . 'auth/login');
                exit;
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }
}
