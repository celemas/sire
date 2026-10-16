<?php

declare(strict_types=1);

namespace Celema\Sire\Tests;

use Celema\Sire\Failure;

class FailureTest extends TestCase
{
	public function testKeyFactory(): void
	{
		$failure = Failure::key('type.custom', 'extra');

		$this->assertSame('type.custom', $failure->key);
		$this->assertSame(['extra'], $failure->args);
		$this->assertNull($failure->fallback);
	}

	public function testFactoriesListNamedArguments(): void
	{
		$this->assertSame([1, 2], Failure::key('type.custom', min: 1, max: 2)->args);
		$this->assertSame([1, 2], Failure::invalid('Invalid', min: 1, max: 2)->args);
	}

	public function testMessageFactory(): void
	{
		$failure = Failure::message('Invalid value');

		$this->assertSame('', $failure->key);
		$this->assertSame([], $failure->args);
		$this->assertSame('Invalid value', $failure->fallback);
	}
}
