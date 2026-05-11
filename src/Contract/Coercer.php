<?php

declare(strict_types=1);

namespace Celemas\Sire\Contract;

use Celemas\Sire\CoercionMode;

/** @api */
interface Coercer
{
	public string $message { get; }

	public function coerce(mixed $pristine, CoercionMode $mode): Coercion;
}
