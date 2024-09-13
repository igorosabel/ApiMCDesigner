<?php declare(strict_types=1);

use Osumi\OsumiFramework\Routing\OUrl;
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
use Osumi\OsumiFramework\App\Module\Home\Closed\ClosedAction;
use Osumi\OsumiFramework\App\Module\Home\Index\IndexAction;
use Osumi\OsumiFramework\App\Module\Home\NotFound\NotFoundAction;

use Osumi\OsumiFramework\App\Filter\LoginFilter;
use Osumi\OsumiFramework\App\Service\WebService;

$api_urls = [
  [
    'url' => '/copy-level',
    'action' => CopyLevelAction::class,
    'filters' => [LoginFilter::class],
  	'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-design',
    'action' => DeleteDesignAction::class,
  	'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/delete-level',
    'action' => DeleteLevelAction::class,
  	'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/design',
    'action' => DesignAction::class,
  	'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/load-designs',
    'action' => LoadDesignsAction::class,
    'filters' => [LoginFilter::class],
  	'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/login',
    'action' => LoginAction::class,
    'type' => 'json'
  ],
  [
    'url' => '/new-design',
    'action' => NewDesignAction::class,
    'filters' => [LoginFilter::class],
  	'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/new-level',
    'action' => NewLevelAction::class,
    'filters' => [LoginFilter::class],
  	'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/register',
    'action' => RegisterAction::class,
    'type' => 'json'
  ],
  [
    'url' => '/rename-level',
    'action' => RenameLevelAction::class,
    'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
  [
    'url' => '/update-design',
    'action' => UpdateDesignAction::class,
    'filters' => [LoginFilter::class],
  	'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/update-design-settings',
    'action' => UpdateDesignSettingsAction::class,
    'filters' => [LoginFilter::class],
  	'services' => [WebService::class],
    'type' => 'json'
  ],
  [
    'url' => '/update-profile',
    'action' => UpdateProfileAction::class,
    'filters' => [LoginFilter::class],
    'type' => 'json'
  ],
];

$home_urls = [
  [
    'url' => '/closed',
    'action' => ClosedAction::class,
  ],
  [
    'url' => '/',
    'action' => IndexAction::class,
  ],
  [
    'url' => '/notFound',
    'action' => NotFoundAction::class,
  ]
];

$urls = [];
OUrl::addUrls($urls, $api_urls, '/api');
OUrl::addUrls($urls, $home_urls);

return $urls;
