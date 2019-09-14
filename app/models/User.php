<?php
class User {
  private $db;

  public function __construct () {
    $this->db = new Database();
  }

  public function register($name, $email, $password) {
    $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');

    $this->db->bind(':name', $name);
    $this->db->bind(':email', $email);
    $this->db->bind(':password', $password);

    return $this->db->execute();
  }

  public function getUserByEmail($email) {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);

    return $this->db->fetch();
  }
}
