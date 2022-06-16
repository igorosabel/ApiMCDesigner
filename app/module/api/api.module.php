<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Routing\OModule;

#[OModule(
	actions: 'login, register, updateProfile, loadDesigns, deleteDesign, updateDesignSettings, newDesign, design, updateDesign, newLevel, renameLevel, copyLevel, deleteLevel',
	type: 'json',
	prefix: '/api'
)]
class apiModule {}
