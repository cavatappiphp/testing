<?php

namespace Cavatappi\Test\BasicApp;

use Cavatappi\Foundation\Command\CommandBus;
use Cavatappi\Foundation\Job\JobManager;
use Cavatappi\Foundation\Module;
use Cavatappi\Foundation\Module\ModuleKit;
use Cavatappi\Infrastructure\Registries\CommandHandlerRegistry;
use Cavatappi\Infrastructure\Registries\EventListenerRegistry;
use Cavatappi\Test\BasicApp\TestJobManager;
use Crell\Tukio\Dispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Basic infrastructure used by tests.
 */
class Model implements Module {
	use ModuleKit;

	private static function listClasses(): array {
		return [
			CommandHandlerRegistry::class,
			EventListenerRegistry::class,
			TestJobManager::class,
		];
	}

	private static function serviceMapOverrides(): array {
		return [
			ListenerProviderInterface::class => EventListenerRegistry::class,
			EventDispatcherInterface::class => Dispatcher::class,
			CommandBus::class => CommandHandlerRegistry::class,
			Dispatcher::class => [ListenerProviderInterface::class],
			JobManager::class => TestJobManager::class,
		];
	}
}
