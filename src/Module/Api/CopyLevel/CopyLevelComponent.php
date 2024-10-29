<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\CopyLevel;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Design;
use Osumi\OsumiFramework\App\Model\Level;
use Osumi\OsumiFramework\App\Component\Api\Level\LevelComponent;

class CopyLevelComponent extends OComponent {
  private ?WebService $ws = null;

  public string $status = 'ok';
  public ?LevelComponent $level = null;

  public function __construct() {
    parent::__construct();
    $this->ws = inject(WebService::class);
    $this->level = new LevelComponent();
  }

	/**
	 * Función para copiar un nivel de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('Login');

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$level = Level::findOne(['id' => $id]);
			if (!is_null($level)){
				$design = Design::findOne(['id' => $level->id_design]);
				if (!is_null($design)) {
					if ($design->id_user === $filter['id']) {
						$this->level->level = $this->ws->copyLevel($design, $level);
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
