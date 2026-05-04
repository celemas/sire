<?php

declare(strict_types=1);

namespace Duon\Sire\Tests;

use Duon\Sire\Coercer\Number;

class CoercerTest extends TestCase
{
	public function testNumberCoercerPreservesNumberKind(): void
	{
		$coercer = new Number();

		$this->assertSame(null, $coercer->coerce(null)->value);
		$this->assertSame(13, $coercer->coerce(13)->value);
		$this->assertSame(13.0, $coercer->coerce(13.0)->value);
		$this->assertSame(13, $coercer->coerce('13')->value);
		$this->assertSame(13.0, $coercer->coerce('13.0')->value);
		$this->assertSame(13.13, $coercer->coerce('13.13')->value);
		$this->assertSame(1000.0, $coercer->coerce('1e3')->value);
	}

	public function testNumberCoercerRejectsInvalidNumbers(): void
	{
		$coercion = new Number()->coerce('23.23invalid');

		$this->assertSame('23.23invalid', $coercion->value);
		$this->assertNotNull($coercion->failure);
	}
}
