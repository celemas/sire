<?php

declare(strict_types=1);

namespace Duon\Sire\Tests;

use Duon\Sire\Coercer\Boolean;
use Duon\Sire\Coercer\FloatingPoint;
use Duon\Sire\Coercer\Integer;
use Duon\Sire\Coercer\Number;
use Duon\Sire\Coercer\Sequence;
use Duon\Sire\Coercer\Text;
use Duon\Sire\Contract\Coercer;

class CoercerTest extends TestCase
{
	public function testIntegerCoercer(): void
	{
		$coercer = new Integer();

		$this->assertCoerces($coercer, null, null, empty: true);
		$this->assertCoerces($coercer, 13, 13);
		$this->assertCoerces($coercer, 13, '13');
		$this->assertCoerces($coercer, 0, '0');
		$this->assertCoerces($coercer, -13, '-13');

		$this->assertRejects($coercer, '23invalid');
		$this->assertRejects($coercer, '23.23');
		$this->assertRejects($coercer, '01');
		$this->assertRejects($coercer, '', empty: true);
	}

	public function testFloatingPointCoercer(): void
	{
		$coercer = new FloatingPoint();

		$this->assertCoerces($coercer, null, null, empty: true);
		$this->assertCoerces($coercer, 13.0, 13);
		$this->assertCoerces($coercer, 13.13, 13.13);
		$this->assertCoerces($coercer, 13.0, '13');
		$this->assertCoerces($coercer, 13.13, '13.13');
		$this->assertCoerces($coercer, 1000.0, '1e3');

		$this->assertRejects($coercer, '23.23invalid');
		$this->assertRejects($coercer, '', empty: true);
	}

	public function testNumberCoercer(): void
	{
		$coercer = new Number();

		$this->assertCoerces($coercer, null, null, empty: true);
		$this->assertCoerces($coercer, 13, 13);
		$this->assertCoerces($coercer, 13.0, 13.0);
		$this->assertCoerces($coercer, 13, '13');
		$this->assertCoerces($coercer, 13.0, '13.0');
		$this->assertCoerces($coercer, 13.13, '13.13');
		$this->assertCoerces($coercer, 1000.0, '1e3');

		$this->assertRejects($coercer, '23.23invalid');
		$this->assertRejects($coercer, '', empty: true);
	}

	public function testBooleanCoercer(): void
	{
		$coercer = new Boolean();

		$this->assertCoerces($coercer, true, true);
		$this->assertCoerces($coercer, true, '1');
		$this->assertCoerces($coercer, true, 'on');
		$this->assertCoerces($coercer, true, 'true');
		$this->assertCoerces($coercer, true, 'yes');
		$this->assertCoerces($coercer, false, false);
		$this->assertCoerces($coercer, false, null, empty: true);
		$this->assertCoerces($coercer, false, '', empty: true);
		$this->assertCoerces($coercer, false, [], empty: true);
		$this->assertCoerces($coercer, false, 0);
		$this->assertCoerces($coercer, false, '0');
		$this->assertCoerces($coercer, false, 'off');
		$this->assertCoerces($coercer, false, 'false');
		$this->assertCoerces($coercer, false, 'no');
		$this->assertCoerces($coercer, false, 'null');

		$this->assertRejects($coercer, 'invalid');
		$this->assertRejects($coercer, 13);
	}

	public function testTextCoercer(): void
	{
		$coercer = new Text();
		$stringable = new class {
			public function __toString(): string
			{
				return 'Stringable';
			}
		};

		$this->assertCoerces($coercer, null, null, empty: true);
		$this->assertCoerces($coercer, '', '', empty: true);
		$this->assertCoerces($coercer, '0', '0');
		$this->assertCoerces($coercer, '0', 0);
		$this->assertCoerces($coercer, '0', 0.0);
		$this->assertCoerces($coercer, '13', 13);
		$this->assertCoerces($coercer, '13.13', 13.13);
		$this->assertCoerces($coercer, 'Stringable', $stringable);
		$this->assertCoerces($coercer, 'Lorem ipsum', 'Lorem ipsum');
		$this->assertCoerces($coercer, '<a href="/test">Test</a>', '<a href="/test">Test</a>');

		$this->assertRejects($coercer, false);
		$this->assertRejects($coercer, true);
		$this->assertRejects($coercer, []);
		$this->assertRejects($coercer, ['key' => 'data']);
	}

	public function testSequenceCoercer(): void
	{
		$coercer = new Sequence();

		$this->assertCoerces($coercer, [], [], empty: true);
		$this->assertCoerces($coercer, [1, 2], [1, 2]);
		$this->assertCoerces($coercer, [['key' => 'data']], [['key' => 'data']]);

		$this->assertRejects($coercer, 'invalid');
		$this->assertRejects($coercer, '', empty: true);
		$this->assertRejects($coercer, 13);
		$this->assertRejects($coercer, ['key' => 'data']);
	}

	private function assertCoerces(
		Coercer $coercer,
		mixed $expected,
		mixed $pristine,
		bool $empty = false,
	): void {
		$coercion = $coercer->coerce($pristine);

		$this->assertSame($expected, $coercion->value);
		$this->assertSame($pristine, $coercion->pristine);
		$this->assertNull($coercion->failure);
		$this->assertSame($empty, $coercion->empty);
	}

	private function assertRejects(Coercer $coercer, mixed $pristine, bool $empty = false): void
	{
		$coercion = $coercer->coerce($pristine);

		$this->assertSame($pristine, $coercion->value);
		$this->assertSame($pristine, $coercion->pristine);
		$this->assertNotNull($coercion->failure);
		$this->assertSame($empty, $coercion->empty);
	}
}
