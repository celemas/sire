<?php

declare(strict_types=1);

namespace Celemas\Sire\Rule;

use Celemas\Sire\Contract;
use Celemas\Sire\Validation;
use Override;

/** @api */
final class Regex implements Contract\Rule
{
	public string $message {
		get => '{label} has an invalid format';
	}

	#[Override]
	public function validate(Contract\Value $value, string ...$args): Contract\Validation
	{
		// As regex patterns could contain colons ':' and rule
		// args are separated by colons and split at their position
		// we need to join them again
		$pattern = implode(':', $args);

		if ($pattern === '') {
			return Validation::invalid();
		}

		return Validation::from(preg_match($pattern, $value->value) === 1);
	}
}
