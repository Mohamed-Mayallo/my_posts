<?php
class Post {
  private $db;

  public function __construct () {
    $this->db = new Database();
  }

  public function getPosts() {
    $this->db->query('
      SELECT *, p.id as postId, u.id as userId, u.createdAt as uCreatedAt, p.createdAt as pCreatedAt FROM posts as p
      JOIN users as u
      ON u.id = p.userId
      ORDER BY pCreatedAt DESC
      ');
    $posts = $this->db->fetchAll();
    return $posts;
  }

  public function getPostById($id) {
    $this->db->query('
      SELECT *, p.id as postId, u.id as userId, u.createdAt as uCreatedAt, p.createdAt as pCreatedAt FROM posts as p
      JOIN users as u
      ON u.id = p.userId
      WHERE p.id = :id
      ');
    $this->db->bind(':id', $id);
    $post = $this->db->fetch();
    return $post;
  }

  public function addPost($title, $body, $image) {
    $this->db->query('INSERT INTO posts (title, body, userId, image) VALUES (:title, :body, :userId, :image)');

    $this->db->bind(':title', $title);
    $this->db->bind(':body', $body);
    $this->db->bind(':image', $image);
    $this->db->bind(':userId', $_SESSION['id']);

    return $this->db->execute();
  }

  public function editPost($id, $title, $body) {
    $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');

    $this->db->bind(':title', $title);
    $this->db->bind(':body', $body);
    $this->db->bind(':id', $id);

    return $this->db->execute();
  }

  public function deletePost($id) {
    $this->db->query('DELETE FROM posts WHERE id = :id');

    $this->db->bind(':id', $id);

    return $this->db->execute();
  }
}
