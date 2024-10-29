<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class User extends OModel {
	#[OPK(
	  comment: 'Clave única de cada usuario'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Email del usuario',
	  nullable: false,
	  max: 50,
	  default: null
	)]
	public ?string $email;

	#[OField(
	  comment: 'Contraseña cifrada del usuario',
	  nullable: false,
	  max: 100,
	  default: null
	)]
	public ?string $pass;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
