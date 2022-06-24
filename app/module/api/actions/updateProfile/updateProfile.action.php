<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/update-profile',
	filters: ['login']
)]
class updateProfileAction extends OAction {
	/**
	 * Función para actualizar los datos de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status    = 'ok';
		$email     = $req->getParamString('email');
		$old_pass  = $req->getParamString('oldPass');
		$new_pass  = $req->getParamString('newPass');
		$conf_pass = $req->getParamString('confPass');
		$filter    = $req->getFilter('login');

		if (is_null($email) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$u = new User();
			if ($u->find(['id'=>$filter['id']])) {
				$u->set('email', $email);
				if ($old_pass!='' && $new_pass!='' && $conf_pass!='' && $new_pass==$conf_pass) {
					if (password_verify($old_pass, $u->get('pass'))) {
						$u->set('pass', password_hash($new_pass, PASSWORD_BCRYPT));
					}
					else {
						$status = 'pass-error';
					}
				}

				if ($status=='ok') {
					$u->save();
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
