<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\DB\OModel;
use Osumi\OsumiFramework\DB\OModelGroup;
use Osumi\OsumiFramework\DB\OModelField;

class Design extends OModel {
	function __construct() {
		$model = new OModelGroup(
			new OModelField(
				name: 'id',
				type: OMODEL_PK,
				comment: 'Clave única de cada diseño'
			),
			new OModelField(
				name: 'id_user',
				type: OMODEL_NUM,
				nullable: false,
				default: null,
				ref: 'user.id',
				comment: 'Id del usuario que hace el diseño'
			),
			new OModelField(
				name: 'name',
				type: OMODEL_TEXT,
				nullable: false,
				default: 'null',
				size: 100,
				comment: 'Nombre del diseño'
			),
			new OModelField(
				name: 'slug',
				type: OMODEL_TEXT,
				nullable: false,
				default: 'null',
				size: 100,
				comment: 'Slug del nombre del diseño'
			),
			new OModelField(
				name: 'size_x',
				type: OMODEL_NUM,
				nullable: false,
				default: 0,
				comment: 'Anchura del diseño'
			),
			new OModelField(
				name: 'size_y',
				type: OMODEL_NUM,
				nullable: false,
				default: 0,
				comment: 'Altura del diseño'
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

	private ?array $levels = null;

	/**
	 * Devuelve la lista de niveles de un diseño
	 *
	 * @return array Lista de niveles
	 */
	public function getLevels(): array {
		if (is_null($this->levels)) {
			$this->loadLevels();
		}
		return $this->levels;
	}

	/**
	 * Guarda la lista de niveles de un diseño
	 *
	 * @param array Lista de niveles
	 *
	 * @return void
	 */
	public function setLevels(array $levels): void {
		$this->levels = $levels;
	}

	/**
	 * Carga la lista de niveles de un diseño
	 *
	 * @return void
	 */
	public function loadLevels(): void {
		$sql = "SELECT * FROM `level` WHERE `id_design` = ? ORDER BY `height` ASC";
		$this->db->query($sql, [$this->get('id')]);

		$levels = [];

		while ($res = $this->db->next()) {
			$level = new Level();
			$level->update($res);

			array_push($levels, $level);
		}

		$this->setLevels($levels);
	}

	/**
	 * Borra un diseño con todos sus niveles
	 *
	 * @return void
	 */
	 public function deleteFull() {
		 $levels = $this->getLevels();
		 foreach ($levels as $level) {
			 $level->delete();
		 }

		 $this->delete();
	 }
}
