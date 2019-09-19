<?php
class Level extends OBase{
  function __construct(){
    $table_name  = 'level';
    $model = [
      'id' => [
        'type'    => Base::PK,
        'comment' => 'Clave única de cada nivel de un diseño'
      ],
      'id_design' => [
        'type'    => Base::NUM,
        'nullable' => false,
        'default' => null,
        'ref' => 'design.id',
        'comment' => 'Id del diseño al que pertenece el nivel'
      ],
      'name' => [
        'type'    => Base::TEXT,
        'nullable' => false,
        'default' => null,
        'size' => 100,
        'comment' => 'Nombre del nivel'
      ],
      'height' => [
        'type'    => Base::NUM,
        'nullable' => false,
        'default' => '1',
        'comment' => 'Altura o piso del nivel dentro del diseño'
      ],
      'data' => [
        'type'    => Base::LONGTEXT,
        'nullable' => true,
        'default' => null,
        'comment' => 'Datos del diseño del nivel'
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
}