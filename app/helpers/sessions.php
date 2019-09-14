<?php
function flash($name = '', $message = '', $class = 'alert alert-success') {
  if (!empty($name) && !empty($message)) {
    unset($_SESSION[$name]);
    $_SESSION[$name] = $message;
  } else {
    if (!empty($_SESSION[$name])) {
      echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
      unset($_SESSION[$name]);
    }
  }
}

function isLogged() {
  if ($_SESSION && $_SESSION['id']) return true;
  else return false;
}