<?php

declare(strict_types=1);

namespace Celemas\Sire\Contract;

use Celemas\Sire\Result;

/** @api */
interface Validator
{
	public function validate(array $data): Result;
}
