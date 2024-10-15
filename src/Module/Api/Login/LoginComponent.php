<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Login;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;

class LoginComponent extends OComponent {
  public string       $status = 'ok';
  public string | int $id     = 'null';
  public string       $token  = '';

	/**
	 * Función para iniciar sesión en la aplicación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$email = $req->getParamString('email');
		$pass  = $req->getParamString('pass');

		if (is_null($email) || is_null($pass)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$u = new User();
			if ($u->find(['email' => $email])) {
				if (password_verify($pass, $u->get('pass'))) {
					$this->id = $u->get('id');

					$tk = new OToken($this->getConfig()->getExtra('secret'));
					$tk->addParam('id',    $this->id);
					$tk->addParam('email', $email);
					$tk->addParam('exp', time() + (24 * 60 * 60));
					$this->token = $tk->getToken();
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
