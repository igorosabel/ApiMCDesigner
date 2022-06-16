<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class Design extends OModel {
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Clave única de cada diseño'
			],
			'id_user' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'user.id',
				'comment' => 'Id del usuario que hace el diseño'
			],
			'name' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Nombre del diseño'
			],
			'slug' => [
				'type'    => OModel::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Slug del nombre del diseño'
			],
			'size_x' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => '0',
				'comment' => 'Anchura del diseño'
			],
			'size_y' => [
				'type'    => OModel::NUM,
				'nullable' => false,
				'default' => '0',
				'comment' => 'Altura del diseño'
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
