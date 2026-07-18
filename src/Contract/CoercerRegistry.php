<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

/** @api */
interface CoercerRegistry
{
	public function get(string $name): ?Coercer;
}
