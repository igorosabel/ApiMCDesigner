<?php
class Design extends OBase{
  function __construct(){
    $table_name  = 'design';
    $model = [
      'id' => [
        'type'    => Base::PK,
        'comment' => 'Clave única de cada diseño'
      ],
      'id_user' => [
        'type'    => Base::NUM,
        'nullable' => false,
        'default' => null,
        'ref' => 'user.id',
        'comment' => 'Id del usuario que hace el diseño'
      ],
      'name' => [
        'type'    => Base::TEXT,
        'nullable' => false,
        'default' => null,
        'size' => 100,
        'comment' => 'Nombre del diseño'
      ],
      'slug' => [
        'type'    => Base::TEXT,
        'nullable' => false,
        'default' => null,
        'size' => 100,
        'comment' => 'Slug del nombre del diseño'
      ],
      'size_x' => [
        'type'    => Base::NUM,
        'nullable' => false,
        'default' => '0',
        'comment' => 'Anchura del diseño'
      ],
      'size_y' => [
        'type'    => Base::NUM,
        'nullable' => false,
        'default' => '0',
        'comment' => 'Altura del diseño'
      ],
      'created_at' => [
        'type'    => Base::CREATED,
        'comment' => 'Fecha de creación del registro'
      ],
      'updated_at' => [
        'type'    => Base::UPDATED,
        'nullable' => true,
        'default' => null,
        'comment' => 'Fecha de última modificación del registro'
      ]
    ];

    parent::load($table_name, $model);
  }

  private $levels = null;

  public function getLevels(){
    if (is_null($this->levels)){
      $this->loadLevels();
    }
    return $this->levels;
  }

  public function setLevels($levels){
    $this->levels = $levels;
  }

  public function loadLevels(){
    $sql = "SELECT * FROM `level` WHERE `id_design` = ? ORDER BY `height` ASC";
    $this->db->query($sql, [$this->get('id')]);

    $levels = [];

    while ($res =   $this->db->next()){
      $level = new Level();
      $level->update($res);

      array_push($levels, $level);
    }

    $this->setLevels($levels);
  }
}