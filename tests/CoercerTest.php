<?php

declare(strict_types=1);

namespace Duon\Sire\Tests;

use Duon\Sire\Coercer\Boolean;
use Duon\Sire\Coercer\FloatingPoint;
use Duon\Sire\Coercer\Integer;
use Duon\Sire\Coercer\Number;
use Duon\Sire\Coercer\Sequence;
use Duon\Sire\Coercer\Text;

class CoercerTest extends TestCase
{
	public function testBuiltInCoercersExposeMessages(): void
	{
		$this->assertSame('{label} must be true or false', new Boolean()->message);
		$this->assertSame('{label} must be a number', new FloatingPoint()->message);
		$this->assertSame('{label} must be a whole number', new Integer()->message);
		$this->assertSame('{label} must be a number', new Number()->message);
		$this->assertSame('{label} must be a list', new Sequence()->message);
		$this->assertSame('{label} must be text', new Text()->message);
	}

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
