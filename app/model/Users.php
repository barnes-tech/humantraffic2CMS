<?php

namespace App\Model;
use Core\{Model,Session,Cookie,Tools};
use Core\Validators\{RequiredValidator,MinValidator,MaxValidator,EmailValidator,UniqueValidator,MatchesValidator};
use App\Model\UserSessions;

class Users extends Model {
  protected static $_table='users', $_archived = true;
  public static $current_user = null;
  public $id,$username,$email,$password,$fname,$lname,$acl,$archived = 0, $confirm;
  public const blacklist = ['id','archived'];

  //add validator
  public function validator() {
    //firstname valdiation
    $this->run_validation(new RequiredValidator($this,['field'=>'fname','msg'=>'First name required.']));
    //username validation
    $this->run_validation(new RequiredValidator($this,['field'=>'username','msg'=>'You must enter a username.']));
    $this->run_validation(new MinValidator($this,['field'=>'username','rule'=>6, 'msg'=>'Username must be at least 6 characters.']));
    $this->run_validation(new MaxValidator($this,['field'=>'username','rule'=>20,'msg'=>'Username must be less than 20 characters']));
    $this->run_validation(new UniqueValidator($this,['field'=>'username','msg'=>'Username taken.']));
    //validation for Email
    $this->run_validation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required']));
    $this->run_validation(new EmailValidator($this,['field'=>'email','msg'=>'Enter valid email.']));
    $this->run_validation(new UniqueValidator($this,['field'=>'email','msg'=>'Email address in use.']));

    //valdiation for password
    $this->run_validation(new MinValidator($this,['field'=>'password','rule'=>8, 'msg'=>'Password must be at least 8 characters.']));
    $this->run_validation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
    if($this->is_new()) {
    $this->run_validation(new MatchesValidator($this,['field'=>'password','rule'=>$this->confirm,'msg'=>'Passwords must match.']));
    }
  }

  public function before_save() {
    $this->time_stamps();
    if($this->is_new()) {
      $this->password = password_hash($this->password,PASSWORD_DEFAULT);
    }
  }

  public static function find_username($username) {
    return self::find_first(['conditions'=>'username = ?','bind'=>[$username]]);
  }

  public static function current_user() {
    if(!isset(self::$current_user) && Session::exists(CURRENT_USER_SESSION_NAME)) {
      self::$current_user = self::find_id((int)Session::get(CURRENT_USER_SESSION_NAME));
    }
  return self::$current_user;
  }


  public function login($remem=false) {
    Session::set(CURRENT_USER_SESSION_NAME, $this->id);
    if ($remem) {
      $hash = md5(uniqid());
      $user_agent = Session::uagent_no_version();
      Cookie::set(REMEMBER_ME_COOKIE_NAME, $hash, REMEMBER_ME_COOKIE_EXPIRY);
      $fields = ['session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$this->id];
      self::get_db()->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?",[$this->id, $user_agent]);
      self::get_db()->insert("user_sessions", $fields);
    }
  }

  public static function user_login_cookie() {
    $user_session = UserSessions::get_from_cookie();
    if($user_session && $user_session->user_id != '') {
      $user = self::find_id((int)$user_session->user_id);
      if($user) {
        $user->login();
      }
      return $user;
    }
    return;
  }

  public function logout() {
    $user_session = UserSessions::get_from_cookie();
    if($user_session) $user_session->delete($user_session->id);
    Session::delete(CURRENT_USER_SESSION_NAME);
    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
     Cookie::delete(REMEMBER_ME_COOKIE_NAME);
    }
    self::$current_user = null;
    return true;
  }

  public function acls() {
    if(empty($this->acl)) return [];
    return json_decode($this->acl, true);
  }

}
