<?php

declare(strict_types=1);

namespace Celemas\Sire\Contract;

/** @api */
interface RuleRegistry
{
	public function get(string $name): ?Rule;
}
