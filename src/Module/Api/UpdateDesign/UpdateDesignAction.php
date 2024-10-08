<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\UpdateDesign;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Tools\OTools;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Design;

class UpdateDesignAction extends OAction {
  private ?WebService $ws = null;

  public string $status = 'ok';

  public function __construct() {
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para actualizar los datos de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id     = $req->getParamInt('id');
		$name   = $req->getParamString('name');
		$size_x = $req->getParamInt('sizeX');
		$size_y = $req->getParamInt('sizeY');
		$levels = $req->getParam('levels');
		$filter = $req->getFilter('Login');

		if (is_null($id) || is_null($name) || is_null($size_x) || is_null($size_y) || is_null($levels) || is_null($filter) || !array_key_exists('id', $filter)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$design = new Design();
			if ($design->find(['id' => $id])) {
				if ($design->get('id_user') === $filter['id']) {
					$design->set('name', urldecode($name));
					$design->set('slug', OTools::slugify(urldecode($name)));
					$design->set('size_x', $size_x);
					$design->set('size_y', $size_y);

					$design->save();

					$updatedLevels = $this->ws->updateLevels($levels);
					if (!$updatedLevels) {
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
