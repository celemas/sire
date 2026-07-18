<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

use Celema\Sire\Failure;

/** @api */
interface Validation
{
	public ?Failure $failure { get; }
}
