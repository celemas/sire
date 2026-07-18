<?php

declare(strict_types=1);

namespace Celema\Sire\Coercer;

use Celema\Sire\Coercion;
use Celema\Sire\CoercionMode;
use Celema\Sire\Contract;
use Celema\Sire\Failure;
use Override;

/** @api */
final class Integer implements Contract\Coercer
{
	public string $message {
		get => '{label} must be a whole number';
	}

	#[Override]
	public function coerce(mixed $pristine, CoercionMode $mode): Contract\Coercion
	{
		if ($mode === CoercionMode::Strict) {
			return self::coerceStrict($pristine);
		}

		$value = self::toInteger($pristine);

		if ($value === null && $pristine !== null) {
			return self::invalid($pristine);
		}

		return new Coercion($value, $pristine, empty: $value === null);
	}

	private static function coerceStrict(mixed $pristine): Coercion
	{
		if ($pristine === null) {
			return new Coercion(null, null, empty: true);
		}

		return is_int($pristine)
			? new Coercion($pristine, $pristine)
			: self::invalid($pristine);
	}

	private static function toInteger(mixed $value): ?int
	{
		if ($value === null || is_int($value)) {
			return $value;
		}

		return self::parseInteger($value);
	}

	private static function invalid(mixed $pristine): Coercion
	{
		return new Coercion(
			$pristine,
			$pristine,
			Failure::invalid(),
			empty: self::isEmpty($pristine),
		);
	}

	private static function parseInteger(mixed $value): ?int
	{
		if (!is_string($value)) {
			return null;
		}

		$parsed = filter_var(trim($value), FILTER_VALIDATE_INT);

		return $parsed === false ? null : $parsed;
	}

	private static function isEmpty(mixed $value): bool
	{
		return $value === null || is_string($value) && trim($value) === '';
	}
}
