<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Design;
use OsumiFramework\App\Component\Api\LevelComponent;

#[OModuleAction(
	url: '/new-level',
	filters: ['login'],
	services: ['web']
)]
class newLevelAction extends OAction {
	/**
	 * Función para crear un nuevo nivel en un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status    = 'ok';
		$id_design = $req->getParamInt('idDesign');
		$name      = $req->getParamString('name');
		$filter    = $req->getFilter('login');
		$level_component = new LevelComponent(['level' => null]);

		if (is_null($id_design) || is_null($name) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id' => $id_design])){
				if ($design->get('id_user') == $filter['id']){
					$level_component->setValue('level', $this->web_service->createNewLevel($design, $name));
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
		$this->getTemplate()->add('level',  $level_component);
	}
}
