<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class Note extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Clave única de cada nota'
			),
			new OModelField(
				name: 'id_level',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'level.id',
				comment: 'Id del nivel donde va la nota'
			),
			new OModelField(
				name: 'pos_x',
				type: OMODEL_NUM,
				nullable: false,
				default: 1,
				comment: 'Posición X de la nota'
			),
			new OModelField(
				name: 'pos_y',
				type: OMODEL_NUM,
				nullable: false,
				default: 1,
				comment: 'Posición Y de la nota'
			),
			new OModelField(
				name: 'data',
				type: OMODEL_LONGTEXT,
				nullable: true,
				default: null,
				comment: 'Contenido de la nota'
			),
			new OModelField(
				name: 'created_at',
				type: OMODEL_CREATED,
				comment: 'Fecha de creación del registro'
			),
			new OModelField(
				name: 'updated_at',
				type: OMODEL_UPDATED,
				nullable: true,
				default: null,
				comment: 'Fecha de última modificación del registro'
			)
		);


		parent::load($model);
	}
}
