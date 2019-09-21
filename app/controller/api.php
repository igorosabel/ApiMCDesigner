<?php
class api extends OController{
  private $web_service;

  function __construct(){
    $this->web_service = new webService($this);
  }

  /*
   * Función para iniciar sesión en la aplicación
   */
  function login($req){
    $status = 'ok';
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);

    $id    = 'null';
    $token = '';

    if ($email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $u = new User();
      if ($u->find(['email'=>$email])){
        if (password_verify($pass, $u->get('pass'))){
          $id = $u->get('id');

          $tk = new OToken($this->getConfig()->getExtra('secret'));
          $tk->addParam('id',   $id);
          $tk->addParam('email', $email);
          $tk->addParam('exp', mktime() + (24 * 60 * 60));
          $token = $tk->getToken();
        }
        else{
          $status = 'error';
        }
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->add('id',     $id);
    $this->getTemplate()->add('token',  $token);
  }
  /*
   * Función para registrarse en la aplicación
   */
  function register($req){
    $status = 'ok';
    $email  = Base::getParam('email', $req['url_params'], false);
    $pass   = Base::getParam('pass',  $req['url_params'], false);
    $id     = 'null';
    $token  = '';

    if ($email===false || $pass===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $u = new User();
      if ($u->find(['email'=>$email])){
        $status = 'error-user';
      }
      else{
        $u->set('email', $email);
        $u->set('pass',  password_hash($pass, PASSWORD_BCRYPT));
        $u->save();

        $id = $u->get('id');

        $tk = new OToken($this->getConfig()->getExtra('secret'));
        $tk->addParam('id',   $id);
        $tk->addParam('email', $email);
        $tk->addParam('exp', mktime() + (24 * 60 * 60));
        $token = $tk->getToken();
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->add('id',     $id);
    $this->getTemplate()->add('token',  $token);
  }

  /*
   * Función para obtener la lista de diseños de un usuario
   */
  function loadDesigns($req){
    $status = 'ok';
    $list   = [];

    if ($req['filter']['status']!='ok'){
      $status = 'error';
    }

    if ($status=='ok'){
      $id_user = $req['filter']['status'];
      $list = $this->web_service->getDesignList($id_user);
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('list', 'api/design_list', ['list'=>$list, 'extra'=>'nourlencode']);
  }

  /*
   * Función para crear un nuevo diseño
   */
  function newDesign($req){
    
  }
}