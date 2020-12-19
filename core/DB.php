<?php

namespace Core;
use \PDO;
use \PDOException;
use Core\Tools;

class DB {
  private static $_connection = null;//before call
  private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_last_insert = null;

  private function __construct() {
    try { //connection exception handler
      $this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);//see config file for connection credentials
      $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {

      die($e->getMessage());
    }
  }
  public static function get_connection() {
    if(!isset(Self::$_connection)) {
      Self::$_connection = new Self();
    }
    return Self::$_connection;
  }

  //query function binds parameters to query
  public function query($sql, $params = [], $class = false) {

    $this->_error = false;
    if($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1; //maybe 0
      if(count($params)) {
        foreach($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }
      if($this->_query->execute()) {
        if($class) {
          $this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS, $class);
        } else {
          $this->_result = $this->_query->fetchALL(PDO::FETCH_OBJ);
        }
        $this->_count = $this->_query->rowCount();//maybe count
        $this->_last_insert = $this->_pdo->lastInsertId();
      }else{
        $this->_error = true;
      }

      return $this;
    }
  }

  public function error(){
    return $this->_error;
  }

  protected function _read($table, $params = [], $class) {
    $columns = '*';
    $joins = "";
    $conditionString = '';
    $bind = [];
    $order = '';
    $limit = '';
    $offset = '';
    // conditions
    //
    //
    if(isset($params['conditions'])) {

      if(is_array($params['conditions'])) {
        foreach($params['conditions'] as $condition){
          $conditionString .=' '.$condition.' AND';
        }
        $conditionString = trim($conditionString);
        $conditionString = rtrim($conditionString, ' AND');
      } else {
        $conditionString = $params['conditions'];
      }
      if($conditionString != '') {
        $conditionString = ' WHERE '.$conditionString; //if the condition string is not empty, cocatinates where clause to start to be
      }
    }

    //columns
    if(array_key_exists('columns',$params)) {
      $columns = $params['columns'];
    }

    //joins
    if(array_key_exists('joins',$params)) {
      foreach($params['joins'] as $join) {
        $joins.= $this->_build_join($join);
      }
      $joins.=" ";
    }
    // binds
    if(array_key_exists('bind', $params)) {
      $bind = $params['bind'];
    }
    // order
    if(array_key_exists('order', $params)) {
      $order = ' ORDER BY '.$params['order'];
    }
    //limit
    if(array_key_exists('limit', $params)) {
      $limit = ' LIMIT '.$params['limit'];
    }
    //offset
    if(array_key_exists('offset',$params)) {
      $offset = $params['offset'];
    }
    //find sql statement

    $sql = "SELECT {$columns} FROM {$table}{$joins}{$conditionString}{$order}{$limit}{$offset}";
    if($this->query($sql, $bind, $class)) {
      if(!count($this->_result)) return false;
      return true;
    }
    return false;
  }

  public function find($table, $params = [],$class=false){
    if($this->_read($table, $params, $class)) {
      return $this->result();
    }
    return false;
  }

  public function find_first($table, $params = [],$class=false) {
    if($this->_read($table, $params,$class)) {
      return $this->first();
    }
    return false;
  }

  //insert function takes two parameters, the table in which to insert and the fields that will be inserted and prepares an sql statement to run against query function
  public function insert($table, $fields = []){
    // declare variabes for field and value strings to be inserted into sql query, fields represent `data` value strings represents '?,' for prepared PDOStatement
    //values will hold store the array of fields to be inserted and for each field it will be concatinated to the field string with the value string having a corrosponding ?, contatinated also.
    $fieldString = '';
    $valueString = '';
    $values = [];
    //loops through fields and adds them the the field string while creating a value string
    foreach($fields as $field => $value) {
      $fieldString .='`'.$field.'`,';//ensure removal of comma at end of string
      $valueString .='?,';//ensure removal of comma at end of string
      $values[]=$value;
    }
    $fieldString = rtrim($fieldString,',');
    $valueString = rtrim($valueString,',');
    $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";

    if(!$this->query($sql, $values)->error()){
      return true;
    }
    return false;
  }
  //update function takes 3 parameters, table to update, id to update (row) and the fields to update in the row and prepares update sql statement to run agaist query function
  public function update($table, $id, $fields = []) {
    $fieldString = '';
    $values = [];
    foreach($fields as $field => $value) {
      $fieldString .= ' '.$field.' = ?,';
      $values[] = $value;
    }

    $fieldString = trim($fieldString);
    $fieldString = rtrim($fieldString, ',');
    $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
    if(!$this->query($sql, $values)->error()){
      return true;
    }
    return false;
  }

  //delete function prepares delete statement to run against query functions
  public function delete($table, $id) {
    $sql = "DELETE FROM {$table} WHERE id = {$id}";
    if(!$this->query($sql)->error()){
      return true;
    }
    return false;
  }
  //get column names from table
  public function get_columns($table) {
    return $this->query("SHOW COLUMNS FROM {$table}")->result();

  }
  //functions to return private variabls for use in application
  public function result(){
    return $this->_result;//returns result as usable data
  }

  public function first(){
    return (!empty($this->_result)) ? $this->_result[0]: [];//returns only first result as usable data
  }

  public function count() {
    return $this->_count;//returns count as usable data
  }

  public function lastID() {
    return $this->_last_insert;//returns lastinserted as usable data
  }
  protected function _build_join($join=[]){
    $table = $join[0];
    $condition = $join[1];
    $alias = $join[2];
    $type = (isset($join[3]))? strtoupper($join[3]) : "INNER";
    $jString = "{$type} JOIN {$table} {$alias} ON {$condition}";
    return " " . $jString;
  }
}
