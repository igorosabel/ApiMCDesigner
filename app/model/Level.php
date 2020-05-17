<?php declare(strict_types=1);
class Level extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'level';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Clave única de cada nivel de un diseño'
			],
			'id_design' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'design.id',
				'comment' => 'Id del diseño al que pertenece el nivel'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Nombre del nivel'
			],
			'height' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => '1',
				'comment' => 'Altura o piso del nivel dentro del diseño'
			],
			'data' => [
				'type'    => OCore::LONGTEXT,
				'nullable' => true,
				'default' => null,
				'comment' => 'Datos del diseño del nivel'
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