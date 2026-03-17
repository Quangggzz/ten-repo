<?php
namespace Controllers;

class AuthController extends \MVC\Controller {
    public function loginForm() {
        if (isLoggedIn()) {
            redirect('/dashboard');
        }
        $this->view('auth/login', ['error' => null]);
    }

    public function login() {
        if (isLoggedIn()) {
            redirect('/dashboard');
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $this->view('auth/login', ['error' => 'Vui lòng nhập tên đăng nhập và mật khẩu']);
            return;
        }

        require_once MODELS . 'User.php';
        $userModel = new \Models\UserModel();
        $user = $userModel->authenticate($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['ho_ten'] = $user['ho_ten'];
            $_SESSION['role'] = $user['role'];
            redirect('/dashboard');
        } else {
            $this->view('auth/login', ['error' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
        }
    }

    public function logout() {
        session_destroy();
        redirect('/login');
    }
}
