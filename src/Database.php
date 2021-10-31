<?php

  namespace App;

  require_once('config.php');

  class Database {

    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct()
    {
      $this->host = DB_SERVER;
      $this->user = DB_USER;
      $this->password = DB_PASS;
      $this->database = DB_NAME;

    }
  
    public function db_connect() {
      $connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);

      if(mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
      }

      return $connection;
    }

    public function db_query($connection, $sql) {
      $result_set = mysqli_query($connection, $sql);
      
      if(substr($sql, 0, 7) == 'SELECT ') {
        $this->confirm_query($result_set);
      }
      return $result_set;
    }

    public function confirm_query($result_set) {
      if(!$result_set) {
        exit("Database query failed.");
      }
    }

    public function db_fetch_assoc($result_set) {
      return mysqli_fetch_assoc($result_set);
    }

    public function db_free_result($result_set) {
      return mysqli_free_result($result_set);
    }

    public function db_num_rows($result_set) {
      return mysqli_num_rows($result_set);
    }

    public function db_insert_id($connection) {
      return mysqli_insert_id($connection);
    }

    public function db_error($connection) {
      return mysqli_error($connection);
    }

    public function db_close($connection) {
      return mysqli_close($connection);
    }

    public function db_escape($connection, $string) {
      return mysqli_real_escape_string($connection, $string);
    }
  }
?>
