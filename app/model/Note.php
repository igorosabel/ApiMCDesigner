<?php
class Note extends OBase{
  function __construct(){
    $table_name  = 'note';
    $model = [
      'id' => [
        'type'    => Base::PK,
        'comment' => 'Clave única de cada nota'
      ],
      'id_level' => [
        'type'    => Base::NUM,
        'nullable' => false,
        'default' => null,
        'ref' => 'level.id',
        'comment' => 'Id del nivel donde va la nota'
      ],
      'pos_x' => [
        'type'    => Base::NUM,
        'nullable' => false,
        'default' => '1',
        'comment' => 'Posición X de la nota'
      ],
      'pos_y' => [
        'type'    => Base::NUM,
        'nullable' => false,
        'default' => '1',
        'comment' => 'Posición Y de la nota'
      ],
      'data' => [
        'type'    => Base::LONGTEXT,
        'nullable' => true,
        'default' => null,
        'comment' => 'Contenido de la nota'
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