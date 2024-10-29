<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Level extends OModel {
	#[OPK(
	  comment: 'Clave única de cada nivel de un diseño'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del diseño al que pertenece el nivel',
	  nullable: false,
	  ref: 'design.id',
	  default: null
	)]
	public ?int $id_design;

	#[OField(
	  comment: 'Nombre del nivel',
	  nullable: false,
	  max: 100,
	  default: null
	)]
	public ?string $name;

	#[OField(
	  comment: 'Altura o piso del nivel dentro del diseño',
	  nullable: false,
	  default: 1
	)]
	public ?int $height;

	#[OField(
	  comment: 'Datos del diseño del nivel',
	  nullable: true,
	  default: null,
	  type: OField::LONGTEXT
	)]
	public ?string $data;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
