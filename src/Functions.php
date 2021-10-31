<?php
  namespace App;

  class Functions {
    private $dbObj;
    private $db;

    public function __construct($db)
    {
      $this->dbObj = $db;
      $this->db = $this->dbObj->db_connect();
    }

    public function find_customers($limit=0, $offset=0) {
      
      $sql = "SELECT * FROM users ";
      $sql .= "ORDER BY last_name ASC, first_name ASC";

      if($limit > 0) {
        $sql .= " LIMIT " . $this->dbObj->db_escape($this->db, $limit);
      }

      if($offset > 0) {
        $sql .= " OFFSET " . $this->dbObj->db_escape($this->db, $offset);
      }
      $result = $this->dbObj->db_query($this->db, $sql);

      return $result;
    }

    public function count_customers() {
      $sql = "SELECT COUNT(*) FROM users ";
      $result = $this->dbObj->db_query($this->db, $sql);
      $array =  $this->dbObj->db_fetch_assoc($result);

      return $array['COUNT(*)'];
    }

    public  function escape($string="") {
      return htmlspecialchars($string);
    }  
  }
?>
