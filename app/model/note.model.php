<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class Note extends OModel {
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Clave única de cada nota'
			],
			'id_level' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'level.id',
				'comment' => 'Id del nivel donde va la nota'
			],
			'pos_x' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => '1',
				'comment' => 'Posición X de la nota'
			],
			'pos_y' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => '1',
				'comment' => 'Posición Y de la nota'
			],
			'data' => [
				'type'    => OModel::LONGTEXT,
				'nullable' => true,
				'default' => null,
				'comment' => 'Contenido de la nota'
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'nullable' => true,
				'default' => null,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($model);
	}
}
