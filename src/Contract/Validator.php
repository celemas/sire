<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

use Celema\Sire\Result;

/** @api */
interface Validator
{
	public function validate(array $data): Result;
}
