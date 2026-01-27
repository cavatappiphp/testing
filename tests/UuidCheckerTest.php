<?php

namespace Cavatappi\Test;

use Cavatappi\Foundation\Factories\UuidFactory;

final class UuidCheckerTest extends TestCase {
	public function testTwoEqualUuidsOfTheSameTypeAreEqual() {
		$expected = UuidFactory::named(UuidFactory::NAMESPACE_DOMAIN, 'cavatappi.dev');
		$actual = UuidFactory::named(UuidFactory::NAMESPACE_DOMAIN, 'cavatappi.dev');
		self::assertUuidEquals($expected, $actual);
	}

	public function testTwoEqualUuidsOfDifferentTypesAreEqual() {
		$expected = $this->randomId();
		$actual = UuidFactory::fromString($expected->toString());
		self::assertUuidEquals($expected, $actual);
	}

	public function testTwoDifferentUuidsOfTheSameTypeAreEqual() {
		$expected = UuidFactory::named(UuidFactory::NAMESPACE_DOMAIN, 'cavatappi.dev');
		$actual = UuidFactory::named(UuidFactory::NAMESPACE_DOMAIN, 'smolblog.com');
		self::assertThat($actual, self::logicalNot(self::uuidEquals($expected)));
	}

	public function testTwoDifferentUuidsOfTheDifferentTypesAreEqual() {
		$expected = $this->randomId();
		$actual = UuidFactory::fromString($this->randomId()->toString());
		self::assertThat($actual, self::logicalNot(self::uuidEquals($expected)));
	}
}