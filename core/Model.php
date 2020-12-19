<?php

namespace Core;
use Core\DB;
use Core\Tools;

class Model {
  protected $_model_name, $_validate=true, $_validation_errors=[];
  public $id;
  protected static $_db, $_table, $_archived = false;

  public function __construct() {
    $this->_model_name = str_replace(' ', '',ucwords(str_replace('_', ' ', static::$_table)));
    $this->on_construct();
  }

  public static function get_db() {
    if(!self::$_db) {
      self::$_db = DB::get_connection();
    }
    return self::$_db;
  }


  public static function get_columns() {
    return static::get_db()->get_columns(static::$_table);
  }

  public function get_columns_for_save() {
    $columns = static::get_columns();
    $fields = [];
    foreach($columns as $column) {
      $key = $column->Field;
      $fields[$key] = $this->{$key};
    }
    return $fields;
  }


  //class protected so usable by extending child classes
  protected static function _archived_params($params){
    if (static::$_archived) {
      if(array_key_exists('conditions',$params)){
        if(is_array($params['conditions'])) {
          $params['conditions'][] = "archived != 1";
        } else {
          $params['conditions'] .= " AND archived != 1";
        }
      }else{
        $params['conditions'] = "archived != 1";
      }
    }
    return $params;
  }

  public static function find($params = []) {
    $params = static::_archived_params($params);
    $result_query = static::get_db()->find(static::$_table, $params, static::class);
    if(!$result_query) return [];
    return $result_query;
  }

  public static function find_first($params = []) {
    $params = static::_archived_params($params);
    $result_query = static::get_db()->find_first(static::$_table, $params, static::class);
    return $result_query;
  }

  protected function pop_obj_data($result) {
    foreach($result as $key => $val){
      $this->$key = $val;
    }
  }

  public static function find_id($id) {
      return static::find_first(['conditions'=>"id = ?",'bind'=>[$id]]);
  }

  public function save() {

    $this->validator();
    $save = false;
    if($this->_validate) {
      //before save used ie password hash
      $this->before_save();
      $fields = $this->get_columns_for_save();
      if($this->is_new()) {
        $save = $this->insert($fields);
        if($save) {
          $this->id = static::get_db()->lastID();
        }
      } else {
        $save = $this->update($fields);
      }
    }
    return $save;
  }

  //calls db insert class and passes params only if all parametersa re passed
  public function insert($fields) {
    if(empty($fields)) return false;
    if(array_key_exists('id',$fields)) unset($fields['id']);
    return static::get_db()->insert(static::$_table, $fields);
  }

  //calls db update class and passes params
  public function update($fields){
    if(empty($fields) || $id = '') return false;
    return static::get_db()->update(static::$_table,$this->id, $fields);
  }

  public function delete() {
    if($this->id ==''||!isset($this->id)) return false;
    $this->before_delete();
    if(static::$_archived) {

      $deleted = $this->update(['archived'=> 1]);
    } else {
      $deleted = static::get_db()->delete(static::$_table, $this->id);
    }
    $this->after_delete();
    return $deleted;
}

  //access query function to allow raw queries on model
  public function query($sql, $bind = []) {
    return static::get_db()->query($sql, $bind);
  }

  public function data() {
    $data = new \stdClass();
    foreach(static::get_columns() as $column) {
      $column_name = $column->Field;
      $data->{$column_name} = $this->{$column_name};
    }
    return $data;
  }
  /**
   * [assign description]
   * @param  array  $params     Parameters to assi
   * @param  array   $list      (Optional) Fields to be blacklisted/whitelisted
   * @param  boolean $blacklist (Optional) False makes list the whitelist.
   * @return Object             Returns object with whitelisted parameters
   */
  public function assign($params,$list=[],$blacklist=true) {
    foreach($params as $key => $value) {
      $whitelisted = true;
      if(sizeof($list) > 0) {
        if($blacklist) {
          $whitelisted = !in_array($key,$list);
        } else {
          $whitelisted = in_array($key,$list);
        }
      }
      if(property_exists($this,$key) && $whitelisted) {
        $this->$key = $value;
      }
    }
    return $this;
  }

  public function run_validation($validator) {

      $key = $validator->field;
      if(!$validator->success) {
        $this->_validate = false;
        $this->_validation_errors[$key] = $validator->msg;
      }
  }

  public function get_validation_errors() {
    return $this->_validation_errors;
  }

  public function is_valid() {
    return $this->_validate;
  }

  public function add_error_msg($field,$msg) {
    $this->_validate = false;
    $this->_validation_errors[$field] = $msg;
  }

  public function before_save() {}

  public function after_save() {}

  public function before_delete() {}

  public function after_delete() {}

  public function on_construct() {}

  public function is_new() {
    return (property_exists($this,'id') && !empty($this->id)) ? false:true;
  }
  /**
   * Method called on save and fails of model validation does not pass
   * @return boolean query not executed on failed validation
   */
  public function validator() {

  }
  /**
   * Generate timestamps for update
   */
  public function time_stamps() {
    $now = date('Y-m-d H:i:s');
    $this->updated_at = $now;
    if(empty($this->id)) {
      $this->created_at = $now;
    }
  }
}
