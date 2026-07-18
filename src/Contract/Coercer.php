<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

use Celema\Sire\CoercionMode;

/** @api */
interface Coercer
{
	public string $message { get; }

	public function coerce(mixed $pristine, CoercionMode $mode): Coercion;
}
