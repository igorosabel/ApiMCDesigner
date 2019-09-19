<?php
class User extends OBase{
  function __construct(){
    $table_name  = 'user';
    $model = [
      'id' => [
        'type'    => Base::PK,
        'comment' => 'Clave única de cada usuario'
      ],
      'user' => [
        'type'    => Base::TEXT,
        'nullable' => false,
        'default' => null,
        'size' => 50,
        'comment' => 'Nombre de usuario'
      ],
      'pass' => [
        'type'    => Base::TEXT,
        'nullable' => false,
        'default' => null,
        'size' => 100,
        'comment' => 'Contraseña cifrada del usuario'
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