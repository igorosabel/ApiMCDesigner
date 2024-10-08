<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Design;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Design;
use Osumi\OsumiFramework\App\Component\Api\Design\DesignComponent;

class DesignAction extends OAction {
  public string $status = 'ok';
  public ?DesignComponent $design = null;

  public function __construct() {
    $this->design = new DesignComponent(['Design' => null]);
  }

	/**
	 * Función para obtener los datos de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('Login');

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$this->status = false;
		}

		if ($this->status ==='ok') {
			$d = new Design();
			if ($d->find(['id' => $id])) {
				if ($d->get('id_user') === $filter['id']) {
					$this->design->setValue('Design', $d);
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
