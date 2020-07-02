<?php declare(strict_types=1);
class api extends OModule {
	private ?webService $web_service = null;

	function __construct(){
		$this->web_service = new webService();
	}

	/**
	 * Función para iniciar sesión en la aplicación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function login(ORequest $req): void {
		$status = 'ok';
		$email  = $req->getParamString('email');
		$pass   = $req->getParamString('pass');

		$id    = 'null';
		$token = '';

		if (is_null($email) || is_null($pass)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$u = new User();
			if ($u->find(['email'=>$email])) {
				if (password_verify($pass, $u->get('pass'))) {
					$id = $u->get('id');

					$tk = new OToken($this->getConfig()->getExtra('secret'));
					$tk->addParam('id',   $id);
					$tk->addParam('email', $email);
					$tk->addParam('exp', mktime() + (24 * 60 * 60));
					$token = $tk->getToken();
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('token',  $token);
	}

	/**
	 * Función para registrarse en la aplicación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function register(ORequest $req): void {
		$status = 'ok';
		$email  = $req->getParamString('email');
		$pass   = $req->getParamString('pass');
		$id     = 'null';
		$token  = '';

		if (is_null($email) || is_null($pass)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$u = new User();
			if ($u->find(['email'=>$email])) {
				$status = 'error-user';
			}
			else {
				$u->set('email', $email);
				$u->set('pass',  password_hash($pass, PASSWORD_BCRYPT));
				$u->save();

				$id = $u->get('id');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',   $id);
				$tk->addParam('email', $email);
				$tk->addParam('exp', mktime() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('token',  $token);
	}

	/**
	 * Función para actualizar los datos de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function updateProfile(ORequest $req): void {
		$status    = 'ok';
		$email     = $req->getParamString('email');
		$old_pass  = $req->getParamString('oldPass');
		$new_pass  = $req->getParamString('newPass');
		$conf_pass = $req->getParamString('confPass');
		$filter    = $req->getFilter('loginFilter');

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

	/**
	 * Función para obtener la lista de diseños de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function loadDesigns(ORequest $req): void {
		$status = 'ok';
		$list   = [];
		$filter = $req->getFilter('loginFilter');

		if (is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$list = $this->web_service->getDesignList($filter['id']);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addPartial('list', 'api/design_list', ['list'=>$list, 'extra'=>'nourlencode']);
	}

	/**
	 * Función para borrar un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function deleteDesign(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('loginFilter');

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id'=>$id])) {
				if ($design->get('id_user')==$filter['id']) {
					$design->deleteFull();
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para editar los detalles de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function updateDesignSettings(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$name   = $req->getParamString('name');
		$size_x = $req->getParamInt('sizeX');
		$size_y = $req->getParamInt('sizeY');
		$filter = $req->getFilter('loginFilter');

		if (is_null($id) || is_null($name) || is_null($size_x) || is_null($size_y) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id'=>$id])) {
				if ($design->get('id_user')==$filter['id']) {
					$design->set('name', $name);
					$design->save();
					if ($size_x!=$design->get('size_x') || $size_y!=$design->sizeY) {
						$this->web_service->updateDesignSize($design, $size_x, $size_y);
					}
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para crear un nuevo diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function newDesign(ORequest $req): void {
		$status = 'ok';
		$name   = $req->getParamString('name');
		$size_x = $req->getParamInt('sizeX');
		$size_y = $req->getParamInt('sizeY');
		$filter = $req->getFilter('loginFilter');

		if (is_null($name) || is_null($size_x) || is_null($size_y) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			$design->set('id_user', $filter['id']);
			$design->set('name',    $name);
			$design->set('slug',    OTools::slugify($name));
			$design->set('size_x',  $size_x);
			$design->set('size_y',  $size_y);

			$design->save();

			$this->web_service->createNewLevel($design);
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para obtener los datos de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function design(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$design = null;
		$filter = $req->getFilter('loginFilter');

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = false;
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id'=>$id])) {
				if ($design->get('id_user')!=$filter['id']) {
					$status = 'error';
					$design = null;
				}
			}
			else {
				$status = 'error';
				$design = null;
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addPartial('design', 'api/design', ['design'=>$design, 'extra'=>'nourlencode']);
	}

	/*
	 * Función para actualizar los datos de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function updateDesign(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$name   = $req->getParamString('name');
		$size_x = $req->getParamInt('sizeX');
		$size_y = $req->getParamInt('sizeY');
		$levels = $req->getParam('levels');
		$filter = $req->getFilter('loginFilter');

		if (is_null($id) || is_null($name) || is_null($size_x) || is_null($size_y) || is_null($levels) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id'=>$id])) {
				if ($design->get('id_user')==$filter['id']) {
					$design->set('name', $name);
					$design->set('slug', OTools::slugify($name));
					$design->set('size_x', $size_x);
					$design->set('size_y', $size_y);

					$design->save();

					$updatedLevels = $this->web_service->updateLevels($levels);
					if (!$updatedLevels) {
						$status = 'error';
					}
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para crear un nuevo nivel en un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function newLevel(ORequest $req): void {
		$status    = 'ok';
		$id_design = $req->getParamInt('idDesign');
		$name      = $req->getParamString('name');
		$filter    = $req->getFilter('loginFilter');
		$new_level = null;

		if (is_null($id_design) || is_null($name) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id'=>$id_design])){
				if ($design->get('id_user')==$filter['id']){
					$new_level = $this->web_service->createNewLevel($design, $name);
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addPartial('level', 'api/level', ['level' => $new_level, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para renombrar un nivel de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function renameLevel(ORequest $req): void {
		$status    = 'ok';
		$id        = $req->getParamInt('id');
		$id_design = $req->getParamInt('idDesign');
		$name      = $req->getParamString('name');
		$filter    = $req->getFilter('loginFilter');
		$new_level = null;

		if (is_null($id) || is_null($id_design) || is_null($name) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$design = new Design();
			if ($design->find(['id'=>$id_design])){
				if ($design->get('id_user')==$filter['id']){
					$level = new Level();
					if ($level->find(['id'=>$id])){
						$level->set('name', $name);
						$level->save();
					}
					else {
						$status = 'error';
					}
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para copiar un nivel de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function copyLevel(ORequest $req): void {
		$status    = 'ok';
		$id        = $req->getParamInt('id');
		$filter    = $req->getFilter('loginFilter');
		$new_level = null;

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$level = new Level();
			if ($level->find(['id'=>$id])){
				$design = new Design();
				if ($design->find(['id'=>$level->get('id_design')])) {
					if ($design->get('id_user')==$filter['id']){
						$new_level = $this->web_service->copyLevel($design, $level);
					}
					else {
						$status = 'error';
					}
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addPartial('level', 'api/level', ['level' => $new_level, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para borrar un nivel de un diseño
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 *
	 * @return void
	 */
	function deleteLevel(ORequest $req): void {
		$status    = 'ok';
		$id        = $req->getParamInt('id');
		$filter    = $req->getFilter('loginFilter');

		if (is_null($id) || is_null($filter) || !array_key_exists('id', $filter)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$level = new Level();
			if ($level->find(['id'=>$id])){
				$design = new Design();
				if ($design->find(['id'=>$level->get('id_design')])) {
					if ($design->get('id_user')==$filter['id']){
						$level->delete();
					}
					else {
						$status = 'error';
					}
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}