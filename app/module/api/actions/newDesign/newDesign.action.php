<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Tools\OTools;
use OsumiFramework\App\Model\Design;

#[OModuleAction(
	url: '/new-design',
	filters: ['login'],
	services: ['web']
)]
class newDesignAction extends OAction {
	/**
	 * Función para crear un nuevo diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$name   = $req->getParamString('name');
		$size_x = $req->getParamInt('sizeX');
		$size_y = $req->getParamInt('sizeY');
		$filter = $req->getFilter('login');

		if (is_null($name) || is_null($size_x) || is_null($size_y) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			$design->set('id_user', $filter['id']);
			$design->set('name',    urldecode($name));
			$design->set('slug',    OTools::slugify(urldecode($name)));
			$design->set('size_x',  $size_x);
			$design->set('size_y',  $size_y);

			$design->save();

			$this->web_service->createNewLevel($design);
		}

		$this->getTemplate()->add('status', $status);
	}
}
