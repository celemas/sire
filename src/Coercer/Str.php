<?php

declare(strict_types=1);

namespace Duon\Sire\Coercer;

use Duon\Sire\Coercion;
use Duon\Sire\Contract;
use Duon\Sire\Failure;
use Override;
use Stringable;

/** @api */
final class Str implements Contract\Coercer
{
	public string $message {
		get => '{label} must be a string';
	}

	#[Override]
	public function coerce(mixed $pristine): Contract\Coercion
	{
		if (!self::isCoercible($pristine)) {
			return new Coercion(
				$pristine,
				$pristine,
				Failure::invalid(),
			);
		}

		$value = self::toString($pristine);

		return new Coercion($value, $pristine, empty: self::isEmpty($value));
	}

	private static function isCoercible(mixed $value): bool
	{
		return (
			$value === null
			|| is_string($value)
			|| is_int($value)
			|| is_float($value)
			|| $value instanceof Stringable
		);
	}

	private static function toString(mixed $value): ?string
	{
		return $value === null ? null : (string) $value;
	}

	private static function isEmpty(?string $value): bool
	{
		return $value === null || $value === '';
	}
}
