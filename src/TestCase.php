<?php

namespace Cavatappi\Test;

use Cavatappi\Foundation\Factories\UuidFactory;
use Cavatappi\Foundation\Value;
use Cavatappi\Test\Constraints\UuidChecker;
use Cavatappi\Test\Constraints\ValueObjectChecker;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Ramsey\Uuid\UuidInterface;
use stdClass;

class TestCase extends PHPUnitTestCase {
	protected mixed $subject;

	protected function randomId(): UuidInterface {
		return UuidFactory::random();
	}

	public static function uuidEquals(UuidInterface $expected): UuidChecker {
		return new UuidChecker($expected);
	}

	public static function assertUuidEquals(UuidInterface $expected, UuidInterface $actual, string $message = ''): void {
		self::assertThat($actual, self::uuidEquals($expected), $message);
	}

	public static function valueObjectEquals(Value $expected): Constraint {
		return new ValueObjectChecker($expected,);
	}

	public static function assertValueObjectEquals(Value $expected, ?object $actual, string $message = ''): void {
		self::assertThat($actual, self::valueObjectEquals($expected), $message);
	}
}
