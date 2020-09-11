<?php

declare(strict_types=1);

namespace OCA\CatFacts\AppInfo;

use OCA\CatFacts\Search\CatFactsProvider;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap {

	public const APP_ID = 'cat_facts';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void {
		$context->registerSearchProvider(CatFactsProvider::class);
	}

	public function boot(IBootContext $context): void {
	}
}
