<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\NewLevel;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Design;
use Osumi\OsumiFramework\App\Component\Api\Level\LevelComponent;

class NewLevelAction extends OAction {
  private ?WebService $ws = null;

  public string $status = 'ok';
  public ?LevelComponent $level = null;

  public function __construct() {
    $this->ws = inject(WebService::class);
    $this->level = new LevelComponent(['Level' => null]);
  }

	/**
	 * Función para crear un nuevo nivel en un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id_design   = $req->getParamInt('idDesign');
		$name        = $req->getParamString('name');
		$filter      = $req->getFilter('Login');

		if (is_null($id_design) || is_null($name) || is_null($filter) || !array_key_exists('id', $filter)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$design = new Design();
			if ($design->find(['id' => $id_design])){
				if ($design->get('id_user') === $filter['id']){
					$this->level->setValue('Level', $this->ws->createNewLevel($design, urldecode($name)));
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
