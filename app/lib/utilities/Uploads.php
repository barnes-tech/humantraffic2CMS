<?php

  namespace App\Lib\Utilities;

  class Uploads {

    private $_errors = [],$_files=[],$_max_size = 5242880,
            $_img_types = [IMAGETYPE_GIF,IMAGETYPE_JPEG,IMAGETYPE_PNG,IMAGETYPE_BMP];

    public function __construct($files) {
      $this->_files = self::restructure_files($files);
    }

    public function upload($bucket,$name,$tmp) {
      if(!file_exists($bucket)) {
        mkdir($bucket,0755,true);
      }
      move_uploaded_file($tmp,ROOT.DS.$bucket.$name);
    }

    public function get_files() {
      return $this->_files;
    }


    public function run_validation() {
      $this->validate_size();
      $this->validate_type();
    }

    public function is_valid() {
      return (empty($this->_errors))? true : $this->_errors;
    }

    protected function validate_type() {
      foreach($this->_files as $file) {
        if(!in_array(exif_imagetype($file['tmp_name']),$this->_img_types)) {
          $name = $file['name'];
          $msg = $name." is not an allowed file type.";
          $this->add_error_msg($name,$msg);
        }
      }
    }

    //check file size
    protected function validate_size() {
      foreach($this->_files as $file) {
        $name = $file['name'];
        if($file['size'] > $this->_max_size) {
          $msg = $name." is over the maximum allowed file size.";
          $this->add_error_message($name,$msg);
        }
      }
    }

    public function add_error_msg($name, $message) {
      if(array_key_exists($name,$this->_errors)) {
        $this->_errors[$name].= $this->_errors[$name] .' '.$message;
      } else {
        $this->_errors[$name] = $message;
      }
    }

    public static function restructure_files($files) {
      $structured = [];
      foreach($files['tmp_name'] as $key => $value) {
        $structured[] = [
          'tmp_name'=>$files['tmp_name'][$key],
          'name'=>$files['name'][$key],
          'size'=>$files['size'][$key],
          'error'=>$files['error'][$key],
          'type'=>$files['type'][$key]
        ];
      }
      return $structured;
    }
  }
