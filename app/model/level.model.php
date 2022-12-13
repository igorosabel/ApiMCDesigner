<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;
use OsumiFramework\OFW\DB\OModelGroup;
use OsumiFramework\OFW\DB\OModelField;

class Level extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Clave única de cada nivel de un diseño'
			),
			new OModelField(
				name: 'id_design',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'design.id',
				comment: 'Id del diseño al que pertenece el nivel'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: null,
				size: 100,
				comment: 'Nombre del nivel'
			),
			new OModelField(
				name: 'height',
				type: OMODEL_NUM,
				nullable: false,
				default: 1,
				comment: 'Altura o piso del nivel dentro del diseño'
			),
			new OModelField(
				name: 'data',
				type: OMODEL_LONGTEXT,
				nullable: true,
				default: null,
				comment: 'Datos del diseño del nivel'
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
