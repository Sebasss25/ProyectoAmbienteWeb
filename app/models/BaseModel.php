<?php
require_once __DIR__ . '/../config/db.php';

class BaseModel {
  protected mysqli $db;
  protected ?string $error = null;

  public function __construct() {
    $this->db = Database::connect();
  }
  public function getError(): ?string { return $this->error; }
}