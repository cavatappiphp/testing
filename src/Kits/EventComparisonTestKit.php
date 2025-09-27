<?php

namespace Cavatappi\Test\Kits;

use Cavatappi\Foundation\DomainEvent\DomainEvent;
use Cavatappi\Test\Constraints\DomainEventChecker;
use PHPUnit\Framework\Constraint\Constraint;

trait EventComparisonTestKit {
	private function eventEquivalentTo(DomainEvent $expected): Constraint {
		return new DomainEventChecker([$expected]);
	}
}
