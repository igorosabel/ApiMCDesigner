<?php
class Note extends OModel{
  function __construct(){
    $table_name  = 'note';
    $model = [
      'id' => [
        'type'    => OCore::PK,
        'comment' => 'Clave única de cada nota'
      ],
      'id_level' => [
        'type'    => OCore::NUM,
        'nullable' => false,
        'default' => null,
        'ref' => 'level.id',
        'comment' => 'Id del nivel donde va la nota'
      ],
      'pos_x' => [
        'type'    => OCore::NUM,
        'nullable' => false,
        'default' => '1',
        'comment' => 'Posición X de la nota'
      ],
      'pos_y' => [
        'type'    => OCore::NUM,
        'nullable' => false,
        'default' => '1',
        'comment' => 'Posición Y de la nota'
      ],
      'data' => [
        'type'    => OCore::LONGTEXT,
        'nullable' => true,
        'default' => null,
        'comment' => 'Contenido de la nota'
      ],
      'created_at' => [
        'type'    => OCore::CREATED,
        'comment' => 'Fecha de creación del registro'
      ],
      'updated_at' => [
        'type'    => OCore::UPDATED,
        'nullable' => true,
        'default' => null,
        'comment' => 'Fecha de última modificación del registro'
      ]
    ];

    parent::load($table_name, $model);
  }
}