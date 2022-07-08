<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\Api\DesignListComponent;

#[OModuleAction(
	url: '/load-designs',
	filters: ['login'],
	services: ['web']
)]
class loadDesignsAction extends OAction {
	/**
	 * Función para obtener la lista de diseños de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('login');
		$design_list_component = new DesignListComponent(['list' => []]);

		if (is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design_list_component->setValue('list', $this->web_service->getDesignList($filter['id']));
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $design_list_component);
	}
}
