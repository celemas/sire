<?php

declare(strict_types=1);

namespace Celema\Sire\Tests;

use Celema\Sire\Coercion;
use Celema\Sire\Failure;

class CoercionTest extends TestCase
{
	public function testProperties(): void
	{
		$failure = new Failure('type.custom');
		$coercion = new Coercion('coerced', 'raw', $failure, empty: true);

		$this->assertSame('coerced', $coercion->value);
		$this->assertSame('raw', $coercion->pristine);
		$this->assertSame($failure, $coercion->failure);
		$this->assertTrue($coercion->empty);
	}

	public function testFailureDefaultsToNull(): void
	{
		$coercion = new Coercion('coerced', 'raw');

		$this->assertNull($coercion->failure);
		$this->assertFalse($coercion->empty);
	}
}
