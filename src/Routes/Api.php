<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Module\Api\CopyLevel\CopyLevelAction;
use Osumi\OsumiFramework\App\Module\Api\DeleteDesign\DeleteDesignAction;
use Osumi\OsumiFramework\App\Module\Api\DeleteLevel\DeleteLevelAction;
use Osumi\OsumiFramework\App\Module\Api\Design\DesignAction;
use Osumi\OsumiFramework\App\Module\Api\LoadDesigns\LoadDesignsAction;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginAction;
use Osumi\OsumiFramework\App\Module\Api\NewDesign\NewDesignAction;
use Osumi\OsumiFramework\App\Module\Api\NewLevel\NewLevelAction;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterAction;
use Osumi\OsumiFramework\App\Module\Api\RenameLevel\RenameLevelAction;
use Osumi\OsumiFramework\App\Module\Api\UpdateDesign\UpdateDesignAction;
use Osumi\OsumiFramework\App\Module\Api\UpdateDesignSettings\UpdateDesignSettingsAction;
use Osumi\OsumiFramework\App\Module\Api\UpdateProfile\UpdateProfileAction;
use Osumi\OsumiFramework\App\Filter\LoginFilter;

ORoute::group('/api', 'json', function() {
  ORoute::post('/copy-level',             CopyLevelAction::class,            [LoginFilter::class]);
  ORoute::post('/delete-design',          DeleteDesignAction::class,         [LoginFilter::class]);
  ORoute::post('/delete-level',           DeleteLevelAction::class,          [LoginFilter::class]);
  ORoute::post('/design',                 DesignAction::class,               [LoginFilter::class]);
  ORoute::post('/load-designs',           LoadDesignsAction::class,          [LoginFilter::class]);
  ORoute::post('/login',                  LoginAction::class);
  ORoute::post('/new-design',             NewDesignAction::class,            [LoginFilter::class]);
  ORoute::post('/new-level',              NewLevelAction::class,             [LoginFilter::class]);
  ORoute::post('/register',               DeleteEntryAction::class);
  ORoute::post('/rename-level',           RenameLevelAction::class,          [LoginFilter::class]);
  ORoute::post('/update-design',          UpdateDesignAction::class,         [LoginFilter::class]);
  ORoute::post('/update-design-settings', UpdateDesignSettingsAction::class, [LoginFilter::class]);
  ORoute::post('/update-profile',         DeleteEntryAction::class,          [LoginFilter::class]);
});
