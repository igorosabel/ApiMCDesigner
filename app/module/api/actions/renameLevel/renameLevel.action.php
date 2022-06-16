<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Design;
use OsumiFramework\App\Model\Level;

#[OModuleAction(
	url: '/rename-level',
	filter: 'login'
)]
class renameLevelAction extends OAction {
	/**
	 * Función para renombrar un nivel de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status    = 'ok';
		$id        = $req->getParamInt('id');
		$id_design = $req->getParamInt('idDesign');
		$name      = $req->getParamString('name');
		$filter    = $req->getFilter('login');
		$new_level = null;

		if (is_null($id) || is_null($id_design) || is_null($name) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id' => $id_design])){
				if ($design->get('id_user') == $filter['id']){
					$level = new Level();
					if ($level->find(['id' => $id])){
						$level->set('name', $name);
						$level->save();
					}
					else {
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
