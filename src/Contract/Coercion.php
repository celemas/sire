<?php

declare(strict_types=1);

namespace Celemas\Sire\Contract;

use Celemas\Sire\Failure;

/** @api */
interface Coercion
{
	public mixed $value { get; }

	public mixed $pristine { get; }

	public ?Failure $failure { get; }

	public bool $empty { get; }
}
