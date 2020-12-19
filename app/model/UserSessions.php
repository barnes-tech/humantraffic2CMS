<?php

namespace App\Model;
use Core\{Model,Cookie,Session};

class UserSessions extends Model {

public $id,$user_id,$session,$user_agent;
protected static $_table = 'user_sessions';

  public static function get_from_cookie() {
    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
      $user_session = self::find_first([
        'conditions' => "user_agent = ? AND session = ?",
        'bind' => [Session::uagent_no_version(),Cookie::get(REMEMBER_ME_COOKIE_NAME)]
      ]);
    }
    return $user_session;
  }
}
