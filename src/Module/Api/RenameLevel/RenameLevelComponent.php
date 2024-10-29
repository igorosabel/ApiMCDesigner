<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\RenameLevel;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Design;
use Osumi\OsumiFramework\App\Model\Level;

class RenameLevelComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para renombrar un nivel de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id        = $req->getParamInt('id');
		$id_design = $req->getParamInt('idDesign');
		$name      = $req->getParamString('name');
		$filter    = $req->getFilter('Login');

		if (is_null($id) || is_null($id_design) || is_null($name) || is_null($filter) || !array_key_exists('id', $filter)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$design = Design::findOne(['id' => $id_design]);
			if (!is_null($design)) {
				if ($design->id_user === $filter['id']) {
					$level = Level::findOne(['id' => $id]);
					if (!is_null($level)) {
						$level->name = $name;
						$level->save();
					}
					else {
						$this->status = 'error';
					}
				}
				else {
					$this->status = 'error';
				}
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
