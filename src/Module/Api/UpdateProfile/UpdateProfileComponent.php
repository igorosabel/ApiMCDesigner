<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\UpdateProfile;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\User;

class UpdateProfileComponent extends OComponent {
  public string $status = 'ok';

	/**
	 * Función para actualizar los datos de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$email     = $req->getParamString('email');
		$old_pass  = $req->getParamString('oldPass');
		$new_pass  = $req->getParamString('newPass');
		$conf_pass = $req->getParamString('confPass');
		$filter    = $req->getFilter('Login');

		if (is_null($email) || is_null($filter) || !array_key_exists('id', $filter)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$u = new User();
			if ($u->find(['id' => $filter['id']])) {
				$u->set('email', $email);

				if ($old_pass !== '' && $new_pass !== '' && $conf_pass !== '' && $new_pass === $conf_pass) {
					if (password_verify($old_pass, $u->get('pass'))) {
						$u->set('pass', password_hash($new_pass, PASSWORD_BCRYPT));
					}
					else {
						$this->status = 'pass-error';
					}
				}

				if ($this->status === 'ok') {
					$u->save();
				}
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
