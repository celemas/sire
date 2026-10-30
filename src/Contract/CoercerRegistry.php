<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

/** @api */
interface CoercerRegistry
{
	public function get(string $name): ?Coercer;

	/** @return array<string, Coercer> Every coercer the registry resolves, by type name. */
	public function all(): array;
}
