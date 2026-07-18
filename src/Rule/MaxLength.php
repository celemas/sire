<?php

declare(strict_types=1);

namespace Celema\Sire\Rule;

use Celema\Sire\Contract;
use Celema\Sire\Validation;
use Override;

/** @api */
final class MaxLength implements Contract\Rule
{
	public string $message {
		get => '{label} must be at most {arg1} characters';
	}

	#[Override]
	public function validate(Contract\Value $value, string ...$args): Contract\Validation
	{
		return Validation::from(strlen($value->value) <= (int) ($args[0] ?? null));
	}
}
