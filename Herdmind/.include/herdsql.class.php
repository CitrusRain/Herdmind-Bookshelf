<?php

class SQL {
  function __construct($host, $user, $pass, $db, $port) {
    $this->socket = NULL;

    if(is_object($host) && get_class($host) == "mysqli") {
      $this->socket = $host;
    } else {
      $this->socket = new mysqli($host, $user, $pass, $db, $port);
    }

    if($this->socket->connect_errno) {
      throw new Exception($this->socket->connect_error);
    }
  }

  function __destruct() {
    if($this->socket != NULL) {
      $this->socket->close();
    }
  }

  //This will cause an exception to be raised if the socket is invalid
  private function alive() {
    if($this->socket == NULL || !is_object($this->socket) || !get_class($this->socket) == "mysqli") {
      throw new Exception("MySQLi socket is closed! ".$this->socket->connect_error);
    }
  }

  private function generate($sql, $func, $args) {
    $qry = array();

    $class = new ReflectionClass(self);
    $method = $class->getMethod($func);

    foreach($method->getParameters() as $param) {
      $qry[] = "<% " . $param . " %>";
    }

    return str_replace($qry, $args, $sql);
  }

  private function fetchArray($sql) {
    if($result = $this->socket->query($sql)) {
      var $arr = array();
      while(($row = $result->fetch_array(MYSQLI_BOTH)) !== NULL) {
        $arr[] = $row;
      }
      return $arr;
    } else if($this->socket->errno) {
      throw new Exception($this->socket->error);
    } else {
      return array();
    }
  }

  private static $POPULAR_FACTS = file_get_contents(dirname(__FILE__) . "/sql/popular_facts.sql");

  public function getPopularFacts($iId, $bMature) {
    $this->alive();

    $sql = $this->generate(self::POPULAR_FACTS, "getPopularFacts", func_get_args());
    
    return $this->fetchArray($sql);
  }
}

?>
