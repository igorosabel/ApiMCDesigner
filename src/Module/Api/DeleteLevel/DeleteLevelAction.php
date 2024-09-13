<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\DeleteLevel;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Design;
use Osumi\OsumiFramework\App\Model\Level;

#[OModuleAction(
	url: '/delete-level',
	filters: ['login']
)]
class DeleteLevelAction extends OAction {
  public string $status = 'ok';

	/**
	 * Function description
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

		if ($this->status=='ok') {
			$level = new Level();
			if ($level->find(['id' => $id])){
				$design = new Design();
				if ($design->find(['id' => $level->get('id_design')])) {
					if ($design->get('id_user') == $filter['id']){
						$level->delete();
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
