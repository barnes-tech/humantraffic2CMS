<?php

namespace Core;
use Core\Session;

class FormHelpers {
  /**
   * Creates an input block to be used on a form
   * @param  string $type        Type of input ie text,password
   * @param  string $label       Inout label
   * @param  string $name        Input name and id
   * @param  string $value       (Optional) The value of the input
   * @param  array  $input_attrs (Optional) Array of CSS class attributes for input
   * @param  array  $div_attrs   (Optional) Array of CSS class attribules for surround div
   * @return string              Returns HTML string representing input block
   */
  public static function input_block($type, $label, $name, $value='', $input_attrs = [], $div_attrs = []) {
    $div_string = self::stringify_attrs($div_attrs);
    $input_string = self::stringify_attrs($input_attrs);
    $html = '<div'.$div_string.'>';
    $html.= '<label for="'.$name.'">'.$label.'</label>';
    $html.= '<div>';
    $html.= '<input type="'.$type.'" id="'.$name.'" value="'.$value.'" name="'.$name.'"'.$input_string.'>';
    $html.= '</div>';
    $html.= '</div>';

    return $html;
  }

  public static function checkbox_block($label, $name, $checked = false, $input_attrs=[],$div_attrs=[]) {
    $div_string = self::stringify_attrs($div_attrs);
    $input_string = self::stringify_attrs($input_attrs);
    $check_string = ($checked)? ' checked="checked"' : '';
    $html = '<div '.$div_string.'>';
    $html.= '<label for="">'.$label.'<input type="checkbox" id="'.$name.'" name="'.$name.'" value="on" '.$check_string.'/></label>';
    $html.= '</div>';

    return $html;
  }
  /**
   * Creates a text input area
   * @param  string $label       Label to be displayed on text area
   * @param  string $name        Id and name of text area to match object field
   * @param  string $value       Value of text area
   * @param  array  $input_attrs (Optional) ID or class attributes for textArea input
   * @param  array  $div_attrs   (Optional) ID or class attributes for textArea surrounding div
   * @return string              [description]
   */
  public static function input_area($label,$name,$value='',$input_attrs=[],$div_attrs = []) {
    $div_string = self::stringify_attrs($div_attrs);
    $input_string = self::stringify_attrs($input_attrs);
    $html = '<div'.$div_string.'>';
    $html.= '<label for="'.$name.'">'.$label.'</label>';
    $html.= '<div>';
    $html.= '<textarea id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$input_string.' rows="6"/>'.$value.'</textarea>';
    $html.= '</div>';
    $html.= '</div>';

    return $html;
  }

  public static function image_upload($label, $name, $input_attrs=[],$div_attrs=[]) {
    $div_string = self::stringify_attrs($div_attrs);
    $html = '<div'.$div_string.'>';
    $html.= '<label for="'.$name.'">'.$label.'</label>';
    $html.= '<div>';
    $html.= '<input type="file" name="'.$name.'[]" id="'.$name.'" multiple/>';
    $html.= '</div>';
    $html.= '</div>';

    return $html;
  }

  public static function select_block($label,$name,$value,$options,$input_attrs=[],$div_attrs=[]) {
    $div_string = self::stringify_attrs($div_attrs);
    $input_string = self::stringify_attrs($input_attrs);
    $id = str_replace('[]','',$name);
    $html = '<div'.$div_string.'>';
    $html.= '<label for="'.$id.'" class="control-label">'.$label.'</label>';
    $html.= '<div>';
    $html.= '<select id="'.$id.'" name="'.$name.'" '.$input_string.'>'.self::select_options($options, $value).'</select>';
    $html.= '</div>';
    $html.= '</div>';
    return $html;
  }

  public static function submit_tag($btn_text, $input_attrs=[]){
    $input_string = self::stringify_attrs($input_attrs);
    $html = '<input type="submit" value="'.$btn_text.'"'.$input_string.'" />';
    return $html;
  }

  /**
   * Submit block creates submit tag and back button
   * @param  string $btn_text    Text on button
   * @param  array  $input_attrs Css attributes for input
   * @param  array  $div_attrs   CCS attributes for containing div
   * @param  string $backlink    returns to method class
   * @return html                HTML Elements
   */
  public static function submit_block($btn_text, $input_attrs=[], $div_attrs=[]) {
    $input_string = self::stringify_attrs($input_attrs);
    $div_string = self::stringify_attrs($div_attrs);
    $html = '<div'.$div_string.'>';
    $html.= '<input type="submit" value="'.$btn_text.'"'.$input_string.' />';
    $html.= '</div>';
    return $html;
  }


  //create attribute string to use in input block
  public static function stringify_attrs($attrs) {
    $string = '';
    foreach($attrs as $key => $val){
      $string.= ' '.$key. '="' .$val.'"';
    }
    return $string;
  }

  public static function generate_token() {
    $token = base64_encode(openssl_random_pseudo_bytes(32));
    Session::set('csrf_token',$token);
    return $token;
  }

  public static function check_token($token){
    return (Session::exists('csrf_token') && Session::get('csrf_token') == $token);
  }

  public static function csrf_input() {
    return '<input type="hidden" name="csrf_token" id="csrf_token" value="'.self::generate_token().'"/>';
  }

  public static function display_errors($errors) {
    $html = '';
    if(!empty($errors)) {
    $html = '<div><ul class="error-box">';
    foreach($errors as $field => $error) {
        $html.='<li>'.$error.'</li>';
        $field = strtolower($field);
        $html .='<script>jQuery("document").ready(function(){jQuery("#'.$field.'").parent().closest("div").addClass("invalid");});</script>';
    }
    $html .='</ul><div>';
  }
    return $html;
  }

  public static function select_options($options,$selected) {
    $html = '';
    foreach($options as $value => $display) {
      $select_string = ($selected == $value)? ' selected="selected"':'';
      $html.= '<option value="'.$value.'"'.$select_string.'>'.$display.'</option>';
    }
    return $html;
  }
}
