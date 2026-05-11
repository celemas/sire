<?php

declare(strict_types=1);

namespace Celemas\Sire\Contract;

/** @api */
interface CoercerRegistry
{
	public function get(string $name): ?Coercer;
}
