<?php

namespace Cavatappi\Test\BasicApp;

use Cavatappi\Foundation\Command\Command;
use Cavatappi\Foundation\Command\CommandBus;
use Cavatappi\Foundation\Module\ModuleUtils;
use Cavatappi\Infrastructure\AppKit;
use Cavatappi\Infrastructure\Registries\ServiceRegistry;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * A basic Cavatappi App to use for testing a module.
 */
class App {
	use AppKit;

	/**
	 * Dependency injection container.
	 *
	 * @var ServiceRegistry
	 */
	public readonly ServiceRegistry $container;

	/**
	 * @param class-string<Module>[]     $models   Module class names to load.
	 * @param array<class-string, array> $services Any individual services to load in addition to the models.
	 */
	public function __construct(array $models, array $services) {
		$classes = [
			...$this->buildDiscoveredClassList([Model::class, ...$models]),
			...ModuleUtils::analyzeClasses(\array_keys($services)),
		];
		$map = [
			...$this->buildDependencyMap([Model::class, ...$models]),
			...$services,
		];

		$this->container = new ServiceRegistry(
			configuration: $map,
			supplements: $this->buildSupplementsForRegistries($classes),
		);
	}

	/**
	 * Execute the given command and run any resulting jobs.
	 *
	 * @param Command $command Command to execute.
	 * @return mixed
	 */
	public function execute(Command $command): mixed {
		// TODO: Serialize and deserialize the Command to ensure that it will successfully translate.
		// Future systems may send Commands to other services.
		$retval = $this->container->get(CommandBus::class)->execute($command);
		$this->container->get(TestJobManager::class)->run();
		return $retval;
	}


	/**
	 * Dispatch the given event and run any resulting jobs.
	 *
	 * @param mixed $event Event to dispatch.
	 * @return mixed
	 */
	public function dispatch(mixed $event): mixed {
		// TODO: Serialize and deserialize the DomainEvent to ensure that it will successfully translate.
		// Future systems may send DomainEvents to other services.

		$retval = $this->container->get(EventDispatcherInterface::class)->dispatch($event);
		$this->container->get(TestJobManager::class)->run();
		return $retval;
	}
}
