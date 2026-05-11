<?php

declare(strict_types=1);

namespace Celemas\Sire\Coercer;

use Celemas\Sire\Coercion;
use Celemas\Sire\CoercionMode;
use Celemas\Sire\Contract;
use Celemas\Sire\Failure;
use Override;

/** @api */
final class ListArray implements Contract\Coercer
{
	public string $message {
		get => '{label} must be a list';
	}

	#[Override]
	public function coerce(mixed $pristine, CoercionMode $mode): Contract\Coercion
	{
		if (
			is_array($pristine)
			&& ($pristine === [] || array_keys($pristine) === range(0, count($pristine) - 1))
		) {
			return new Coercion($pristine, $pristine, empty: $pristine === []);
		}

		return new Coercion(
			$pristine,
			$pristine,
			Failure::invalid(),
			empty: self::isEmpty($pristine),
		);
	}

	private static function isEmpty(mixed $value): bool
	{
		return $value === null || $value === '' || $value === [];
	}
}
