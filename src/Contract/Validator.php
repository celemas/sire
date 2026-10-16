<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

use Celema\Sire\Result;

/** @api */
interface Validator
{
	/** @param array<array-key, mixed> $data */
	public function validate(array $data): Result;
}
