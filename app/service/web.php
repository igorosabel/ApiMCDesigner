<?php declare(strict_types=1);
class webService extends OService {
	/**
	 * Load service tools
	 */
	function __construct() {
		$this->loadService();
	}

	/**
	 * Devuelve la lista de diseños de un usuario
	 *
	 * @param int $id_user Id del usuario del que obtener los diseños
	 *
	 * @return array
	 */
	public function getDesignList(int $id_user): array {
		$db = new ODB();
		$sql = "SELECT * FROM `design` WHERE `id_user` = ? ORDER BY `updated_at`";
		$db->query($sql, [$id_user]);
		$list = [];

		while ($res=$db->next()) {
			$des = new Design();
			$des->update($res);

			array_push($list, $des);
		}

		return $list;
	}

	/**
	 * Crea un nuevo nivel en blanco para un diseño
	 *
	 * @param Design $design Diseño al que añadir un nivel
	 *
	 * @return void
	 */
	public function createNewLevel(Design $design): void {
		$levels = $design->getLevels();

		$data = [];
		for ($i=0; $i<$design->get('size_y'); $i++) {
			$row = [];
			for ($j=0;$j<$design->get('size_x'); $j++) {
				array_push($row, 0);
			}
			array_push($data, $row);
		}

		$level = new Level();
		$level->set('id_design', $design->get('id'));
		$level->set('name',      'Level '.( count($levels) +1) );
		$level->set('height',    ( count($levels) +1) );
		$level->set('data',      json_encode($data) );
		$level->save();
	}

	/**
	 * Actualiza los niveles de un diseño
	 *
	 * @param array $levels Lista de niveles
	 *
	 * @return bool Devuelve si todos los niveles han sido actualizados o si no se ha encontrado alguno
	 */
	public function updateLevels(array $levels): bool {
		foreach ($levels as $level) {
			$lev = new Level();
			if ($lev->find(['id'=>$level['id']])) {
				$lev->set('name', $level['name']);
				$lev->set('height', $level['height']);
				$lev->set('data', json_encode($level['data']));
				$lev->save();
			}
			else {
				return false;
			}
		}
		return true;
	}
}