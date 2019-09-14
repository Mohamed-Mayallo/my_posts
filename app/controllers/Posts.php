<?php
class Posts extends Controller {
  public function __construct() {
    if (!isLogged()) header('Location: ' . URL_ROOT . '/posts');

    $this->postModel = $this->model('Post');
  }

  public function index() {
    $posts = $this->postModel->getPosts();

    $this->view('posts/index', ['posts' => $posts]);
  }

  public function add() {
    $data = [
      'title' => '',
      'body' => '',
      'image' => '',
      'title_err' => '',
      'body_err' => '',
      'image_err' => '',
    ];

    if (isset($_POST['submit']) && $_POST['submit'] === 'Add post') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'title_err' => '',
        'body_err' => '',
      ];

      if (empty($data['title'])) {
        $data['title_err'] = 'Title field is required';
      }
      if (empty($data['body'])) {
        $data['body_err'] = 'Body field is required';
      }
      if (empty($_FILES['image']['size'])) {
        $data['image_err'] = 'Post image field is required';
      }

      $fileRes = uploader($_FILES['image']);
      if ($fileRes['error']) $data['image_err'] = $fileRes['error'];
      $data['image'] = $fileRes['path'];

      if (!$data['title_err'] && !$data['body_err'] && !$data['image_err']) {
        $post = $this->postModel->addPost($data['title'], $data['body'], $data['image']);
        if ($post) {
          flash('post_message', 'You have added a new post successfully');
          header("Location: " . URL_ROOT . '/posts');
        } else {
          die('Something went wrong');
        }
      }
    }

    $this->view('posts/add', $data);
  }

  public function edit($id) {
    $post = $this->postModel->getPostById($id);
    if (!$post) header('Location: ' . URL_ROOT . '/posts');

    $data = [
      'postId' => $post->postId,
      'title' => $post->title,
      'body' => $post->body,
      'title_err' => '',
      'body_err' => '',
    ];

    if (isset($_POST['submit']) && $_POST['submit'] === 'Edit post') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'postId' => $post->postId,
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'title_err' => '',
        'body_err' => '',
      ];

      if (empty($data['title'])) {
        $data['title_err'] = 'Title field is required';
      }
      if (empty($dabody)) {
        $data['body_err'] = 'Body field is required';
      }

      if (!$data->title_err && !$data->body_err) {
        $post = $this->postModel->editPost($post->postId, $data['title'], $data['body']);
        if ($post) {
          flash('post_message', 'Post updated successfully');
          header("Location: " . URL_ROOT . '/posts');
        } else {
          die('Something went wrong');
        }
      }
    }

    $this->view('posts/edit', $data);
  }

  public function show($id) {
    $post = $this->postModel->getPostById($id);
    if (!$post) header('Location: ' . URL_ROOT . '/posts');

    $this->view("posts/show", ['post' => $post]);
  }

  public function delete($id) {
    $post = $this->postModel->getPostById($id);
    if (!$post) header('Location: ' . URL_ROOT . '/posts');

    $deleted = $this->postModel->deletePost($id);
    if ($deleted) {
      unlink(getFilePath($post->image));

      flash('post_message', 'Post deleted successfully');
      header('Location: ' . URL_ROOT . '/posts');
    }
  }
}
