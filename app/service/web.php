<?php
class webService extends OService{
  function __construct(){
    $this->loadService();
  }

  public function getDesignList($id_user){
    $db = new ODB();
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

  public function createNewLevel($design){
    $levels = $design->getLevels();

    $data = [];
    for ($i=0; $i<$design->get('size_y'); $i++){
      $row = [];
      for ($j=0;$j<$design->get('size_x'); $j++){
        array_push($row, 0);
      }
      array_push($data, $row);
    }

    $level = new Level();
    $level->set('id_design', $design->get('id'));
    $level->set('name',      'Level '.( count($levels) +1) );
    $level->set('height',    ( count($levels) +1) );
    $level->set('data',      json_encode($data) );
    $level->save();
  }

  public function updateLevels($levels){
    foreach ($levels as $level){
      $lev = new Level();
      if ($lev->find(['id'=>$level['id']])){
        $lev->set('name', $level['name']);
        $lev->set('height', $level['height']);
        $lev->set('data', json_encode($level['data']));
        $lev->save();
      }
      else{
        return false;
      }
    }
    return true;
  }
}