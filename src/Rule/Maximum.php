<?php

declare(strict_types=1);

namespace Celema\Sire\Rule;

use Celema\Sire\Contract;
use Celema\Sire\Validation;
use Override;

/** @api */
final class Maximum implements Contract\Rule, Contract\NamedArguments
{
	public string $message {
		get => '{label} must be at most {max}';
	}

	public array $arguments {
		get => ['max'];
	}

	#[Override]
	public function validate(Contract\Value $value, string ...$args): Contract\Validation
	{
		return Validation::from(is_numeric($value->value) && (float) $value->value <= (float) ($args[0] ?? null));
	}
}
