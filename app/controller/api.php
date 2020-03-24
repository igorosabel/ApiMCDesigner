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
    $email  = OTools::getParam('email', $req['params'], false);
    $pass   = OTools::getParam('pass',  $req['params'], false);

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
    $email  = OTools::getParam('email', $req['params'], false);
    $pass   = OTools::getParam('pass',  $req['params'], false);
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

    if ($req['loginFilter']['status']!='ok'){
      $status = 'error';
    }

    if ($status=='ok'){
      $id_user = $req['loginFilter']['id'];
      $list = $this->web_service->getDesignList($id_user);
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('list', 'api/design_list', ['list'=>$list, 'extra'=>'nourlencode']);
  }

  /*
   * Función para crear un nuevo diseño
   */
  function newDesign($req){
    $status = 'ok';
    $name   = OTools::getParam('name',  $req['params'], false);
    $size_x = OTools::getParam('sizeX', $req['params'], false);
    $size_y = OTools::getParam('sizeY', $req['params'], false);

    if ($name===false || $size_x===false || $size_y===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $id_user = $req['loginFilter']['id'];

      $design = new Design();
      $design->set('id_user', $id_user);
      $design->set('name',    $name);
      $design->set('slug',    OTools::slugify($name));
      $design->set('size_x',  $size_x);
      $design->set('size_y',  $size_y);

      $design->save();

      $this->web_service->createNewLevel($design);
    }

    $this->getTemplate()->add('status', $status);
  }

  /*
   * Función para obtener los datos de un diseño
   */
  function design($req){
    $status = 'ok';
    $id     = OTools::getParam('id', $req['params'], false);
    $design = null;

    if ($id===false){
      $status = false;
    }

    if ($status=='ok'){
      $design = new Design();
      if (!$design->find(['id'=>$id])){
        $status = 'error';
        $design = null;
      }
    }

    $this->getTemplate()->add('status', $status);
    $this->getTemplate()->addPartial('design', 'api/design', ['design'=>$design, 'extra'=>'nourlencode']);
  }

  /*
   * Función para actualizar los datos de un diseño
   */
  function updateDesign($req){
    $status = 'ok';
    $id     = OTools::getParam('id',     $req['params'], false);
    $name   = OTools::getParam('name',   $req['params'], false);
    $size_x = OTools::getParam('sizeX',  $req['params'], false);
    $size_y = OTools::getParam('sizeY',  $req['params'], false);
    $levels = OTools::getParam('levels', $req['params'], false);

    if ($id===false || $name===false || $size_x===false || $size_y===false || $levels===false){
      $status = 'error';
    }

    if ($status=='ok'){
      $des = new Design();
      if ($des->find(['id'=>$id])){
        $des->set('name', $name);
        $des->set('slug', OTools::slugify($name));
        $des->set('size_x', $size_x);
        $des->set('size_y', $size_y);

        $des->save();

        $updatedLevels = $this->web_service->updateLevels($levels);
        if (!$updatedLevels){
          $status = 'error';
        }
      }
      else{
        $status = 'error';
      }
    }

    $this->getTemplate()->add('status', $status);
  }
}