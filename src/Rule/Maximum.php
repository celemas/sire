<?php

declare(strict_types=1);

namespace Celemas\Sire\Rule;

use Celemas\Sire\Contract;
use Celemas\Sire\Validation;
use Override;

/** @api */
final class Maximum implements Contract\Rule
{
	public string $message {
		get => '{label} must be at most {arg1}';
	}

	#[Override]
	public function validate(Contract\Value $value, string ...$args): Contract\Validation
	{
		return Validation::from($value->value <= (float) ($args[0] ?? null));
	}
}
