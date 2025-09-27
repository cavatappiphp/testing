<?php

namespace Cavatappi\Test;

use Cavatappi\Foundation\Factories\UuidFactory;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Ramsey\Uuid\UuidInterface;

class TestCase extends PHPUnitTestCase {
	protected mixed $subject;

	protected function randomId(): UuidInterface {
		return UuidFactory::random();
	}
}
