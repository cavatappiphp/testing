<?php

namespace Cavatappi\Test\Constraints;

use InvalidArgumentException;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Util\Exporter;
use Ramsey\Uuid\UuidInterface;
use SebastianBergmann\Comparator\ComparisonFailure;

/**
 * Compare two DomainEvents while ignoring ID and timestamp.
 */
class UuidChecker extends Constraint {
	/**
	 * @param UuidInterface $expected Events to check against.
	 */
	public function __construct(private UuidInterface $expected) {
	}

	public function toString(): string {
		return 'two UUIDs are equal';
	}

	protected function failureDescription($other): string {
		return $this->toString();
	}

	protected function matches(mixed $other): bool {
		if (!\is_a($other, UuidInterface::class)) {
			throw new InvalidArgumentException('Object is not a UUID.');
		}

		return $this->expected->equals($other);
	}

	protected function fail(mixed $other, string $description, ?ComparisonFailure $comparisonFailure = null): never {
		if ($comparisonFailure === null) {
			$comparisonFailure = new ComparisonFailure(
				$this->expected,
				$other,
				Exporter::export($this->expected),
				Exporter::export($other),
				'Failed asserting that two UUIDs are equal.'
			);
		}

		parent::fail($other, $description, $comparisonFailure);
	}
}
