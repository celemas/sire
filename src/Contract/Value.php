<?php

declare(strict_types=1);

namespace Celemas\Sire\Contract;

/** @api */
interface Value
{
	public mixed $value { get; }

	public mixed $pristine { get; }

	public bool $empty { get; }
}
