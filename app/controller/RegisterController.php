<?php

namespace App\Controller;
use Core\{Controller,Router,Session,Tools};
use App\Model\{Users,Login};

//register user class extending functionality of core controller and
class RegisterController extends Controller {

  public function on_construct() {
    $this->view->set_layout('default');

  }

  public function login_action($user = '') {
    $login_model  = new Login();
    if($this->request->is_post()) {
      //form validation

      $this->request->csrf_check();
      $login_model->assign($this->request->get());
      $login_model->validator();
      if($login_model->is_valid()) {
        $user = Users::find_username($this->request->get('username'));
        if($user && password_verify($this->request->get('password'),$user->password)){

          $remember = $login_model->get_remember_me_checked();
          $user->login($remember);
          Session::add_msg('success','Welcome back '.$user->fname);
          Router::redirect('home/index');
        } else {
            $login_model->add_error_msg('Username','There is an error with your useraname or password.');
        }
      }
    }
    $this->view->loginModel = $login_model;
    $this->view->display_errors = $login_model->get_validation_errors();
    $this->view->render('register/login');
  }

  public function logout_action() {
    if(Users::current_user()) {
      Users::current_user()->logout();
    }
    Router::redirect('register/login');
  }

  public function register_action() {
    $new_user = new Users();
    if($this->request->is_post()) {
      $this->request->csrf_check();
      $new_user->assign($this->request->get());
      $new_user->confirm = $this->request->get('password_match');
      if($new_user->save()) {
        Session::add_msg('success','User added.');
        Router::redirect('home/index');
      }
    }
    $this->view->new_user = $new_user;
    $this->view->display_errors = $new_user->get_validation_errors();
    $this->view->render('register/register');
  }
}
