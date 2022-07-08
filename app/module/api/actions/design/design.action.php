<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Design;
use OsumiFramework\App\Component\Api\DesignComponent;

#[OModuleAction(
	url: '/design',
	filters: ['login']
)]
class designAction extends OAction {
	/**
	 * Función para obtener los datos de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('login');
		$design_component = new DesignComponent(['design' => null]);

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = false;
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id'=>$id])) {
				if ($design->get('id_user') == $filter['id']) {
					$design_component->setValue('design', $design);
				}
				else {
					$status = 'error';
					$design = null;
				}
			}
			else {
				$status = 'error';
				$design = null;
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('design', $design_component);
	}
}
