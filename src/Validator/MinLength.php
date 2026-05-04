<?php

declare(strict_types=1);

namespace Duon\Sire\Validator;

use Duon\Sire\Contract;
use Duon\Sire\Validation;
use Override;

/** @api */
final class MinLength implements Contract\Validator
{
	public string $message {
		get => '{label} must be at least {arg1} characters';
	}

	#[Override]
	public function validate(Contract\Value $value, string ...$args): Contract\Validation
	{
		return Validation::from(strlen($value->value) >= (int) ($args[0] ?? null));
	}
}
