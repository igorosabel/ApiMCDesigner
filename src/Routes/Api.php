<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
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
use Osumi\OsumiFramework\App\Filter\LoginFilter;

ORoute::prefix('/api', function() {
  ORoute::post('/copy-level',             CopyLevelComponent::class,            [LoginFilter::class]);
  ORoute::post('/delete-design',          DeleteDesignComponent::class,         [LoginFilter::class]);
  ORoute::post('/delete-level',           DeleteLevelComponent::class,          [LoginFilter::class]);
  ORoute::post('/design',                 GetDesignComponent::class,            [LoginFilter::class]);
  ORoute::post('/load-designs',           LoadDesignsComponent::class,          [LoginFilter::class]);
  ORoute::post('/login',                  LoginComponent::class);
  ORoute::post('/new-design',             NewDesignComponent::class,            [LoginFilter::class]);
  ORoute::post('/new-level',              NewLevelComponent::class,             [LoginFilter::class]);
  ORoute::post('/register',               DeleteEntryComponent::class);
  ORoute::post('/rename-level',           RenameLevelComponent::class,          [LoginFilter::class]);
  ORoute::post('/update-design',          UpdateDesignComponent::class,         [LoginFilter::class]);
  ORoute::post('/update-design-settings', UpdateDesignSettingsComponent::class, [LoginFilter::class]);
  ORoute::post('/update-profile',         DeleteEntryComponent::class,          [LoginFilter::class]);
});
