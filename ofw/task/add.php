<?php declare(strict_types=1);
/**
 * Add new modules, actions, services or tasks
 */
class addTask extends OTask {
	public function __toString() {
		return $this->getColors()->getColoredString('add', 'light_green').': '.OTools::getMessage('TASK_ADD');
	}

	/**
	 * Creates a new module with the given parameters
	 *
	 * @param array Array with the action "module" and the name of the new module
	 *
	 * @return void
	 */
	private function createModule(array $params): void {
		$path = $this->getConfig()->getDir('ofw_template').'add/createModule.php';
		$values = [
			'colors'           => $this->getColors(),
			'module_name'      => '',
			'module_file'      => '',
			'module_path'      => '',
			'module_templates' => '',
			'error'            => 0
		];

		if (count($params)<2) {
			$values['error'] = 1;
			echo OTools::getPartial($path, $values);
			exit;
		}

		$values['module_name']      = $params[1];
		$values['module_path']      = $this->getConfig()->getDir('app_module').$values['module_name'];
		$values['module_templates'] = $values['module_path'].'/template';
		$values['module_file']      = $values['module_path'].'/'.$values['module_name'].'.php';

		$add = OTools::addModule($values['module_name']);

		if ($add['status']=='exists') {
			$values['error'] = 2;
			echo OTools::getPartial($path, $values);
			exit;
		}

		echo OTools::getPartial($path, $values);
		exit;
	}

	/**
	 * Creates a new action with the given parameters
	 *
	 * @param array Array with the action "action", name of the module where the action should go, name of the new action, URL of the action and optionally action type
	 *
	 * @return void
	 */
	private function createAction(array $params): void {
		$path = $this->getConfig()->getDir('ofw_template').'add/createAction.php';
		$values = [
			'colors'       => $this->getColors(),
			'service_name' => '',
			'service_file' => '',
			'error'        => 0
		];

		if (count($params)<4) {
			$values['error'] = 1;
			echo OTools::getPartial($path, $values);
			exit;
		}

		$values['module_name']      = $params[1];
		$values['module_path']      = $this->getConfig()->getDir('app_module').$values['module_name'];
		$values['module_templates'] = $values['module_path'].'/template';
		$values['module_file']      = $values['module_path'].'/'.$values['module_name'].'.php';
		$values['action_name']      = $params[2];
		$values['action_url']       = $params[3];
		$values['action_type']      = isset($params[4]) ? $params[4] : null;

		$add = OTools::addAction($values['module_name'], $values['action_name'], $values['action_url'], $values['action_type']);
		$values['action_template']  = $values['module_templates'].'/'.$values['action_name'].'.'.$add['type'];

		if ($add['status']=='no-module') {
			$values['error'] = 2;
			echo OTools::getPartial($path, $values);
			exit;
		}
		if ($add['status']=='action-exists') {
			$values['error'] = 3;
			echo OTools::getPartial($path, $values);
			exit;
		}
		if ($add['status']=='template-exists') {
			$values['error'] = 4;
			echo OTools::getPartial($path, $values);
			exit;
		}

		echo OTools::getPartial($path, $values);
		exit;
	}

	/**
	 * Creates a new service with the given parameters
	 *
	 * @param array Array with the action "service" and the name of the new service
	 *
	 * @return void
	 */
	private function createService(array $params): void {
		$path = $this->getConfig()->getDir('ofw_template').'add/createService.php';
		$values = [
			'colors'       => $this->getColors(),
			'service_name' => '',
			'service_file' => '',
			'error'        => 0
		];

		if (count($params)<2) {
			$values['error'] = 1;
			echo OTools::getPartial($path, $values);
			exit;
		}

		$values['service_name'] = $params[1];
		$values['service_file'] = $this->getConfig()->getDir('app_service').$values['service_name'].'.php';

		$add = OTools::addService($values['service_name']);

		if ($add['status']=='exists') {
			$values['error'] = 2;
			echo OTools::getPartial($path, $values);
			exit;
		}

		echo OTools::getPartial($path, $values);
		exit;
	}

	/**
	 * Creates a new task with the given parameters
	 *
	 * @param array Array with the action "task" and the name of the new task
	 *
	 * @return void
	 */
	private function createTask(array $params): void {
		$path = $this->getConfig()->getDir('ofw_template').'add/createTask.php';
		$values = [
			'colors'    => $this->getColors(),
			'task_name' => '',
			'task_file' => '',
			'error'     => 0
		];

		if (count($params)<2) {
			$values['error'] = 1;
			echo OTools::getPartial($path, $values);
			exit;
		}

		$values['task_name'] = $params[1];
		$values['task_file'] = $this->getConfig()->getDir('app_task').$values['task_name'].'.php';

		$add = OTools::addTask($values['task_name']);

		if ($add['status']=='exists') {
			$values['error'] = 2;
			echo OTools::getPartial($path, $values);
			exit;
		}
		if ($add['status']=='ofw-exists') {
			$values['error'] = 2;
			$values['task_file'] = $this->getConfig()->getDir('ofw_task').$values['task_name'].'.php';
			echo OTools::getPartial($path, $values);
			exit;
		}

		echo OTools::getPartial($path, $values);
		exit;
	}

	/**
	 * Run the task
	 *
	 * @param array Command line parameters: option and name
	 *
	 * @return void Echoes framework information
	 */
	public function run(array $params): void {
		$available_options = ['module', 'action', 'service', 'task'];
		$option = (count($params)>0) ? $params[0] : 'none';
		$option = in_array($option, $available_options) ? $option : 'none';

		switch ($option) {
			case 'module': {
				$this->createModule($params);
			}
			break;
			case 'action': {
				$this->createAction($params);
			}
			break;
			case 'service': {
				$this->createService($params);
			}
			break;
			case 'task': {
				$this->createTask($params);
			}
			break;
			case 'none': {
				$path   = $this->getConfig()->getDir('ofw_template').'add/add.php';
				$values = [
					'colors' => $this->getColors()
				];

				echo OTools::getPartial($path, $values);
			}
		}
	}
}