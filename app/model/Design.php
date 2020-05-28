<?php declare(strict_types=1);
class Design extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'design';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Clave única de cada diseño'
			],
			'id_user' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => null,
				'ref' => 'user.id',
				'comment' => 'Id del usuario que hace el diseño'
			],
			'name' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Nombre del diseño'
			],
			'slug' => [
				'type'    => OCore::TEXT,
				'nullable' => false,
				'default' => null,
				'size' => 100,
				'comment' => 'Slug del nombre del diseño'
			],
			'size_x' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => '0',
				'comment' => 'Anchura del diseño'
			],
			'size_y' => [
				'type'    => OCore::NUM,
				'nullable' => false,
				'default' => '0',
				'comment' => 'Altura del diseño'
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