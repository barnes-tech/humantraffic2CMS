<?php

namespace Core;

  class View {
    protected $_head, $_body, $_sitle, $_output_buffer, $_layout = DEFAULT_LAYOUT;



    public function render($v_name) {
      $v_array = explode('/',$v_name);
      $v_string = implode(DS,$v_array);
      if(file_exists(ROOT.DS.'app'.DS.'view'.DS.$v_string.'.php')) {
        include(ROOT.DS.'app'.DS.'view'.DS.$v_string.'.php');
        include(ROOT.DS.'app'.DS.'view'.DS.'layouts'.DS.$this->_layout.'.php');
      } else {
        die('The view "' . $v_name .'" does not exist in view.');
      }
    }

    public function content($type) {
      if($type =='head') {
        return $this->_head;
      } elseif($type == 'body') {
        return $this->_body;
      }
      return false;
    }
    //method to prepare output
    public function start($type) {
      $this->_output_buffer = $type;
      ob_start();
    }

    public function end() {
      if($this->_output_buffer == 'head'){
        $this->_head = ob_get_clean();
      } elseif($this->_output_buffer == 'body') {
        $this->_body = ob_get_clean();
      } else {
        die('Error. End method declared before start method.');
      }
    }

    public function sitle() {
      if($this->_sitle == '') return SITE_TITLE;
      return $this->_sitle;
    }

    public function set_sitle($title) {
      $this->_sitle = $title;
    }

    public function set_layout($path) {
      $this->_layout = $path;
    }

    public function insert($path) {
      include ROOT.DS.'app'.DS.'view'.DS.$path.'.php';
    }

    public function partial($group, $partial) {
      include ROOT.DS.'app'.DS.'view'.DS.$group.DS.'partials'.DS.$partial.'.php';
    }
  }
