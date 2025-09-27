<?php

namespace Cavatappi\Test;

use Cavatappi\Foundation\Factories\HttpMessageFactory;
use Cavatappi\Foundation\Utilities\HttpVerb;
use InvalidArgumentException;
use Cavatappi\Test\TestCase;
use Cavatappi\Test\Kits\HttpMessageComparisonTestKit;

final class HttpMessageIsEquivalentTest extends TestCase {
	use HttpMessageComparisonTestKit;

	public function testEquivalentHttpMessagesPass() {
		$messageOne = HttpMessageFactory::response(
			code: 451,
			headers: ['Link' => '<https://spqr.example.org/legislatione>; rel="blocked-by"'],
			body: ['code' => '451', 'blockedBy' => 'Copyright, LLC'],
		);
		$messageTwo = HttpMessageFactory::response(
			code: 451,
			headers: ['Link' => '<https://spqr.example.org/legislatione>; rel="blocked-by"'],
			body: ['code' => '451', 'blockedBy' => 'Copyright, LLC'],
		);

		$this->assertThat($messageTwo, $this->httpMessageEqualTo($messageOne));
	}

	public function testDifferentHttpMessagesFail() {
		$messageOne = HttpMessageFactory::response(
			code: 451,
			headers: ['Link' => '<https://spqr.example.org/legislatione>; rel="blocked-by"'],
			body: ['code' => '451', 'blockedBy' => 'Copyright, LLC'],
		);
		$messageTwo = HttpMessageFactory::request(verb: HttpVerb::GET, url: 'https://smol.blog/');

		$this->assertThat($messageTwo, $this->logicalNot($this->httpMessageEqualTo($messageOne)));
	}

	public function testNotPassingAnHttpMessagetWillThrowException() {
		$this->expectException(InvalidArgumentException::class);

		$messageOne = HttpMessageFactory::response(
			code: 451,
			headers: ['Link' => '<https://spqr.example.org/legislatione>; rel="blocked-by"'],
			body: ['code' => '451', 'blockedBy' => 'Copyright, LLC'],
		);
		$messageTwo = 'Hello!';

		$this->assertThat($messageTwo, $this->httpMessageEqualTo($messageOne));
	}
}
