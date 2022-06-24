<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Design;
use OsumiFramework\App\Model\Level;
use OsumiFramework\App\Component\LevelComponent;

#[OModuleAction(
	url: '/copy-level',
	filters: ['login'],
	services: ['web'],
	components: ['api/level']
)]
class copyLevelAction extends OAction {
	/**
	 * Función para copiar un nivel de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status    = 'ok';
		$id        = $req->getParamInt('id');
		$filter    = $req->getFilter('login');
		$level_component = new LevelComponent(['level' => null]);

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$level = new Level();
			if ($level->find(['id' => $id])){
				$design = new Design();
				if ($design->find(['id' => $level->get('id_design')])) {
					if ($design->get('id_user') == $filter['id']){
						$level_component->setValue('level', $this->web_service->copyLevel($design, $level));
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
		$this->getTemplate()->add('level',  $level_component);
	}
}
