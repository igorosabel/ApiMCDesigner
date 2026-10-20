<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Middleware\LoginMiddleware;
use Osumi\OsumiFramework\App\Module\Api\CopyLevel\CopyLevelComponent;
use Osumi\OsumiFramework\App\Module\Api\DeleteDesign\DeleteDesignComponent;
use Osumi\OsumiFramework\App\Module\Api\DeleteLevel\DeleteLevelComponent;
use Osumi\OsumiFramework\App\Module\Api\GetDesign\GetDesignComponent;
use Osumi\OsumiFramework\App\Module\Api\LoadDesigns\LoadDesignsComponent;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginComponent;
use Osumi\OsumiFramework\App\Module\Api\NewDesign\NewDesignComponent;
use Osumi\OsumiFramework\App\Module\Api\NewLevel\NewLevelComponent;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterComponent;
use Osumi\OsumiFramework\App\Module\Api\RenameLevel\RenameLevelComponent;
use Osumi\OsumiFramework\App\Module\Api\UpdateDesign\UpdateDesignComponent;
use Osumi\OsumiFramework\App\Module\Api\UpdateDesignSettings\UpdateDesignSettingsComponent;
use Osumi\OsumiFramework\App\Module\Api\UpdateProfile\UpdateProfileComponent;

ORoute::prefix('/api', function() {
  ORoute::post('/copy-level',             CopyLevelComponent::class,            ['before' => [LoginMiddleware::class]]);
  ORoute::post('/delete-design',          DeleteDesignComponent::class,         ['before' => [LoginMiddleware::class]]);
  ORoute::post('/delete-level',           DeleteLevelComponent::class,          ['before' => [LoginMiddleware::class]]);
  ORoute::post('/design',                 GetDesignComponent::class,            ['before' => [LoginMiddleware::class]]);
  ORoute::post('/load-designs',           LoadDesignsComponent::class,          ['before' => [LoginMiddleware::class]]);
  ORoute::post('/login',                  LoginComponent::class);
  ORoute::post('/new-design',             NewDesignComponent::class,            ['before' => [LoginMiddleware::class]]);
  ORoute::post('/new-level',              NewLevelComponent::class,             ['before' => [LoginMiddleware::class]]);
  ORoute::post('/register',               RegisterComponent::class);
  ORoute::post('/rename-level',           RenameLevelComponent::class,          ['before' => [LoginMiddleware::class]]);
  ORoute::post('/update-design',          UpdateDesignComponent::class,         ['before' => [LoginMiddleware::class]]);
  ORoute::post('/update-design-settings', UpdateDesignSettingsComponent::class, ['before' => [LoginMiddleware::class]]);
  ORoute::post('/update-profile',         UpdateProfileComponent::class,        ['before' => [LoginMiddleware::class]]);
});
