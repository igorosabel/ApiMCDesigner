<?php
class home extends OController{
  /*
   * Página temporal, sitio cerrado
   */
  function closed($req){
    OUrl::goToUrl('https://mcdesigner.osumi.es');
  }

  /*
   * Home pública
   */
  function index($req){
    OUrl::goToUrl('https://mcdesigner.osumi.es');
  }

  /*
   * Página de error 404
   */
  function notFound($req){
    OUrl::goToUrl('https://mcdesigner.osumi.es');
  }
}