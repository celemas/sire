<?php

declare(strict_types=1);

namespace Duon\Sire\Tests;

use Duon\Sire\Failure;

class FailureTest extends TestCase
{
	public function testKeyFactory(): void
	{
		$failure = Failure::key('type.custom', 'extra');

		$this->assertSame('type.custom', $failure->key);
		$this->assertSame(['extra'], $failure->args);
		$this->assertNull($failure->fallback);
	}

	public function testMessageFactory(): void
	{
		$failure = Failure::message('Invalid value');

		$this->assertSame('', $failure->key);
		$this->assertSame([], $failure->args);
		$this->assertSame('Invalid value', $failure->fallback);
	}
}
