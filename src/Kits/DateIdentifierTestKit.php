<?php

namespace Cavatappi\Test\Kits;

use Ramsey\Uuid\UuidInterface;

trait DateIdentifierTestKit {
	/**
	 * Asserts that two identifiers are created from the same date. A v7 UUID hashes the date, then adds random bytes.
	 * This function trims the random bytes and compares the remaining data.
	 */
	private function assertIdentifiersHaveSameDate(UuidInterface $expected, UuidInterface $actual) {
		$expectedTrim = \substr(\strval($expected), offset: 0, length: -8);
		$actualTrim = \substr(\strval($actual), offset: 0, length: -8);

		$this->assertEquals($expectedTrim, $actualTrim);
	}
}
