<?php

declare(strict_types=1);

namespace Celema\Sire\Rule;

use Celema\Sire\Contract;
use Celema\Sire\Validation;
use Override;

/** @api */
final class MaxLength implements Contract\NamedArguments
{
	public string $message {
		get => '{label} must be at most {max} characters';
	}

	public array $arguments {
		get => ['max'];
	}

	#[Override]
	public function validate(Contract\Value $value, string ...$args): Contract\Validation
	{
		return Validation::from(is_string($value->value) && mb_strlen($value->value) <= (int) ($args[0] ?? null));
	}
}
