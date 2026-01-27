<?php

namespace Cavatappi\Test\Constraints;

use Cavatappi\Foundation\Value;
use InvalidArgumentException;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Util\Exporter;
use SebastianBergmann\Comparator\ComparisonFailure;
use Stringable;

/**
 * Compare two DomainEvents while ignoring ID and timestamp.
 */
class ValueObjectChecker extends Constraint {
	/**
	 * @param Value $expected Events to check against.
	 */
	public function __construct(private Value $expected) {
	}

	public function toString(): string {
		return 'two Value objects are equal';
	}

	protected function failureDescription($other): string {
		return $this->toString();
	}

	protected function matches(mixed $other): bool {
		if (!\is_a($other, Value::class)) {
			throw new InvalidArgumentException('Object is not a Value.');
		}

		return $this->expected->equals($other);
	}

	protected function fail(mixed $other, string $description, ?ComparisonFailure $comparisonFailure = null): never {
		if ($comparisonFailure === null) {
			$comparisonFailure = new ComparisonFailure(
				$this->expected,
				$other,
				Exporter::export($this->exportValue($this->expected)),
				Exporter::export($this->exportValue($other)),
				'Failed asserting that two Value objects are equal.'
			);
		}

		parent::fail($other, $description, $comparisonFailure);
	}

	public static function exportValue(Value $obj): array {
		$values = get_object_vars($obj);
		return array_map(self::exportValueProp(...), $values);
	}

	private static function exportValueProp(mixed $prop): mixed {
		return match(true) {
			is_a($prop, Stringable::class) => strval($prop),
			is_a($prop, Value::class) => self::exportValue($prop),
			is_array($prop) => array_map(self::exportValueProp(...), $prop),
			default => $prop,
		};
	}
}
