<?php

declare(strict_types=1);

namespace Celema\Sire\Rule;

use Celema\Sire\Contract;
use Celema\Sire\Validation;
use Override;

/** @api */
final class Required implements Contract\ValidatesEmpty
{
	public string $message {
		get => '{label} is required';
	}

	#[Override]
	public function validate(Contract\Value $value, string ...$args): Contract\Validation
	{
		return Validation::from(!$value->empty);
	}
}
