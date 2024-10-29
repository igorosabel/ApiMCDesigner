<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\UpdateDesign;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Tools\OTools;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Design;

class UpdateDesignComponent extends OComponent {
  private ?WebService $ws = null;

  public string $status = 'ok';

  public function __construct() {
    parent::__construct();
    $this->ws = inject(WebService::class);
  }

	/**
	 * Función para actualizar los datos de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
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
			$design = Design::findOne(['id' => $id]);
			if (!is_null($design)) {
				if ($design->id_user === $filter['id']) {
					$design->name   = urldecode($name);
					$design->slug   = OTools::slugify(urldecode($name));
					$design->size_x = $size_x;
					$design->size_y = $size_y;

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
