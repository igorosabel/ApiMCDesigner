<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class Note extends OModel {
	#[OPK(
	  comment: 'Clave única de cada nota'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del nivel donde va la nota',
	  nullable: false,
	  ref: 'level.id',
	  default: null
	)]
	public ?int $id_level;

	#[OField(
	  comment: 'Posición X de la nota',
	  nullable: false,
	  default: 1
	)]
	public ?int $pos_x;

	#[OField(
	  comment: 'Posición Y de la nota',
	  nullable: false,
	  default: 1
	)]
	public ?int $pos_y;

	#[OField(
	  comment: 'Contenido de la nota',
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
