<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Tools\OTools;
use OsumiFramework\App\Model\Design;

#[OModuleAction(
	url: '/update-design',
	filter: 'login',
	services: ['web']
)]
class updateDesignAction extends OAction {
	/**
	 * Función para actualizar los datos de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$name   = $req->getParamString('name');
		$size_x = $req->getParamInt('sizeX');
		$size_y = $req->getParamInt('sizeY');
		$levels = $req->getParam('levels');
		$filter = $req->getFilter('login');

		if (is_null($id) || is_null($name) || is_null($size_x) || is_null($size_y) || is_null($levels) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id' => $id])) {
				if ($design->get('id_user') == $filter['id']) {
					$design->set('name', $name);
					$design->set('slug', OTools::slugify($name));
					$design->set('size_x', $size_x);
					$design->set('size_y', $size_y);

					$design->save();

					$updatedLevels = $this->web_service->updateLevels($levels);
					if (!$updatedLevels) {
						$status = 'error';
					}
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
