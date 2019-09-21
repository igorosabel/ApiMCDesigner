<?php
class webService extends OService{
  function __construct($controller=null){
    $this->setController($controller);
  }

  public function getDesignList($id_user){
    $db = $this->getController()->getDB();
    $sql = "SELECT * FROM `design` WHERE `id_user` = ? ORDER BY `updated_at`";
    $db->query($sql, [$id_user]);
    $list = [];

    while ($res=$db->next()){
      $des = new Design();
      $des->update($res);

      array_push($list, $des);
    }

    return $list;
  }
}