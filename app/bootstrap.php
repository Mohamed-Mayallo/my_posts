<?php
session_start();

require_once '../app/config/config.php';
require_once '../app/helpers/sessions.php';
require_once '../app/helpers/uploader.php';

spl_autoload_register(function($className) {
  require_once "../app/libs/$className.php";
});

new Core();