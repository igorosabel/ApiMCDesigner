<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Register;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;

class RegisterComponent extends OComponent {
  public string       $status = 'ok';
  public string | int $id     = 'null';
  public string       $token  = '';

	/**
	 * Función para registrarse en la aplicación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$email = $req->getParamString('email');
		$pass  = $req->getParamString('pass');

		if (is_null($email) || is_null($pass)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$u = User::findOne(['email' => $email]);
			if (!is_null($u)) {
				$this->status = 'error-user';
			}
			else {
        $u = User::create();
				$u->email = $email;
				$u->pass  = password_hash($pass, PASSWORD_BCRYPT);
				$u->save();

				$this->id = $u->id;

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $this->id);
				$tk->addParam('email', $email);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
		}
	}
}
