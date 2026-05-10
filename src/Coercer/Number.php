<?php

declare(strict_types=1);

namespace Duon\Sire\Coercer;

use Duon\Sire\Coercion;
use Duon\Sire\CoercionMode;
use Duon\Sire\Contract;
use Duon\Sire\Failure;
use Override;

/** @api */
final class Number implements Contract\Coercer
{
	public string $message {
		get => '{label} must be a number';
	}

	#[Override]
	public function coerce(mixed $pristine, CoercionMode $mode): Contract\Coercion
	{
		if ($mode === CoercionMode::Strict) {
			return self::coerceStrict($pristine);
		}

		$value = self::toNumber($pristine);

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

		return is_int($pristine) || is_float($pristine) && is_finite($pristine)
			? new Coercion($pristine, $pristine)
			: self::invalid($pristine);
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

	private static function isEmpty(mixed $value): bool
	{
		return $value === null || is_string($value) && trim($value) === '';
	}

	private static function toNumber(mixed $value): int|float|null
	{
		if ($value === null || is_int($value)) {
			return $value;
		}

		if (is_float($value)) {
			return self::finiteFloat($value);
		}

		return self::isNumericString($value)
			? self::fromNumericString(trim($value))
			: null;
	}

	private static function isNumericString(mixed $value): bool
	{
		return is_string($value) && is_numeric($value);
	}

	private static function fromNumericString(string $value): int|float|null
	{
		$integer = filter_var($value, FILTER_VALIDATE_INT);

		if ($integer !== false) {
			return $integer;
		}

		return self::finiteFloat((float) $value);
	}

	private static function finiteFloat(float $value): ?float
	{
		return is_finite($value) ? $value : null;
	}
}
