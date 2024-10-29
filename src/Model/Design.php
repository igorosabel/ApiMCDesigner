<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Design extends OModel {
	#[OPK(
	  comment: 'Clave única de cada diseño'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del usuario que hace el diseño',
	  nullable: false,
	  ref: 'user.id',
	  default: null
	)]
	public ?int $id_user;

	#[OField(
	  comment: 'Nombre del diseño',
	  nullable: false,
	  max: 100,
	  default: 'null'
	)]
	public ?string $name;

	#[OField(
	  comment: 'Slug del nombre del diseño',
	  nullable: false,
	  max: 100,
	  default: 'null'
	)]
	public ?string $slug;

	#[OField(
	  comment: 'Anchura del diseño',
	  nullable: false,
	  default: 0
	)]
	public ?int $size_x;

	#[OField(
	  comment: 'Altura del diseño',
	  nullable: false,
	  default: 0
	)]
	public ?int $size_y;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$levels = Level::where(['id_design' => $this->id], ['order_by' => 'height#asc']);
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
