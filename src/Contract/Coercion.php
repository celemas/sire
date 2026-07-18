<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

use Celema\Sire\Failure;

/** @api */
interface Coercion
{
	public mixed $value { get; }

	public mixed $pristine { get; }

	public ?Failure $failure { get; }

	public bool $empty { get; }
}
