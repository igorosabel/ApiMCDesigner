<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\DeleteDesign;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Design;

class DeleteDesignAction extends OAction {
  public string $status = 'ok';

	/**
	 * Función para borrar un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('Login');

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$design = new Design();
			if ($design->find(['id' => $id])) {
				if ($design->get('id_user') === $filter['id']) {
					$design->deleteFull();
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
