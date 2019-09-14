<?php
class Database {
  private $dbHost = DB_HOST;
  private $dbUser = DB_USER;
  private $dbPass = DB_PASS;
  private $dbName = DB_NAME;

  private $dbh;
  private $stmt;
  private $error;

  public function __construct() {
    $dns = "mysql:host=$this->dbHost;dbname=$this->dbName";
    $options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
      $this->dbh = new PDO($dns, $this->dbUser, $this->dbPass, $options);
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  public function query($sql) {
    $this->stmt = $this->dbh->prepare($sql);
  }

  public function bind($param, $value, $type = null) {
    if (is_null($type)) {
      switch ($value) {
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    $this->stmt->bindValue($param, $value, $type);
  }

  public function execute() {
    return $this->stmt->execute();
  }

  public function fetchAll() {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function fetch() {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  public function rowCount() {
    $this->execute(); 
    return $this->stmt->rowCount();
  }
}
