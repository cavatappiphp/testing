<?php

namespace Cavatappi\Test;

use Cavatappi\Test\BasicApp\App;

class AppTest extends TestCase {
	public const INCLUDED_MODELS = [];

	protected App $app;

	protected function setUp(): void {
		$this->app = new App(models: static::INCLUDED_MODELS, services: $this->createMockServices());
	}

	protected function createMockServices(): array {
		return [];
	}

	protected function assertCompleteDependencyMap(bool $skipContainers = false): void {
		$needs = $this->app->getUnmetDependencies($skipContainers);

		$output = '';
		foreach ($needs as $dep => $services) {
			$output .= "• {$dep} required by:\n";
			$output .= implode("\n", array_map(fn($srv) => "  - {$srv}", $services));
			$output .= "\n";
		}

		$this->assertEmpty(
			$needs,
			"The following interfaces are missing implementations or test stubs:\n" . $output,
		);
	}
}
