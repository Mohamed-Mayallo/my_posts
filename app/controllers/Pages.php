<?php
class Pages extends Controller {
  public function __construct() {}

  public function index () {
    if (isLogged()) header('Location: ' . URL_ROOT . '/posts');

    $this->view('pages/index', ['title' => 'Welcome', 'desc' => 'Description for My Posts App']);
  }

  public function about() {
    $this->view('pages/about', ['title' => 'About us', 'desc' => 'Description for My Posts About page']);
  }
}
