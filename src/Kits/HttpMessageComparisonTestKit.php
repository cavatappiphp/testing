<?php

namespace Cavatappi\Test\Kits;

use Cavatappi\Test\Constraints\HttpMessageIsEquivalent;
use PHPUnit\Framework\Constraint\Constraint;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

trait HttpMessageComparisonTestKit {
	private function httpMessageEqualTo(RequestInterface|ResponseInterface $expected): Constraint {
		return new HttpMessageIsEquivalent($expected);
	}
}
