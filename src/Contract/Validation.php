<?php

declare(strict_types=1);

namespace Celemas\Sire\Contract;

use Celemas\Sire\Failure;

/** @api */
interface Validation
{
	public ?Failure $failure { get; }
}
