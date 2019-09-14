<?php
class Users extends Controller {
  public function __construct() {
    $this->userModel = $this->model('User');
  }

  public function register() {
    if (isset($_SESSION['id'])) {
      header('Location: ' . URL_ROOT);
    }
    
    $data = [
      'name' => '',
      'email' => '',
      'password' => '',
      'confirm_password' => '',
      'name_err' => '',
      'email_err' => '',
      'password_err' => '',
      'confirm_password_err' => '',
    ];

    if (isset($_POST['submit']) && $_POST['submit'] === 'Register') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'name' => trim($_POST['name']),
        'email' => trim(strtolower($_POST['email'])),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ];

      if (empty($data['name'])) {
        $data['name_err'] = 'Name field is required';
      }
      if (empty($data['email'])) {
        $data['email_err'] = 'Email field is required';
      } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $data['email_err'] = 'Email is incorrect format';
      } else if ($this->userModel->getUserByEmail($data['email'])) {
        $data['email_err'] = 'This email is already taken';
      }
      if (empty($data['password'])) {
        $data['password_err'] = 'Password field is required';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password is too short';
      }
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Confirm password field is required';
      } elseif ($data['password'] !== $data['confirm_password']) {
        $data['confirm_password_err'] = 'Confirmed password is not matched';
      }

      if (!$data['name_err'] && !$data['email_err'] && !$data['password_err'] && !$data['confirm_password_err']) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $saved = $this->userModel->register($data['name'], $data['email'], $data['password']);
        if ($saved) {
          flash('register_success', 'You have registered successfully');
          header("Location: " . URL_ROOT . '/users/login');
        } else {
          die('Something went wrong');
        }
      }
    }

    $this->view('users/register', $data);
  }

  public function login() {
    if (isset($_SESSION['id'])) {
      header('Location: ' . URL_ROOT);
    }

    $data = [
      'email' => '',
      'password' => '',
      'email_err' => '',
      'password_err' => '',
    ];

    if (isset($_POST['submit']) && $_POST['submit'] === 'Login') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim(strtolower($_POST['email'])),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => '',
        'login_err' => ''
      ];

      if (empty($data['email'])) {
        $data['email_err'] = 'Email field is required';
      } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $data['email_err'] = 'Email is incorrect format';
      }

      $user = $this->userModel->getUserByEmail($data['email']);

      if (empty($data['password'])) {
        $data['password_err'] = 'Password field is required';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password is too short';
      } else if ($user && !password_verify($data['password'], $user->password)) {
        $data['password_err'] = 'Password is incorrect';
      }

      if (!$data['email_err'] && !$data['password_err']) {
        if ($user) {
          $_SESSION['id'] = $user->id;
          $_SESSION['email'] = $user->email;
          $_SESSION['name'] = $user->name;

          header('Location: ' . URL_ROOT . '/posts');
          exit();
          // session_write_close();
          // die();
        } else {
          $data['login_err'] = 'This user is not found';
        }
      }
    }

    $this->view('users/login', $data);
  }

  public function logout() {
    session_destroy();
    header("Location: " . URL_ROOT . '/');
  }
}
