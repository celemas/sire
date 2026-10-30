<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

/** @api */
interface RuleRegistry
{
	public function get(string $name): ?Rule;

	/** @return array<string, Rule> Every rule the registry resolves, by name. */
	public function all(): array;
}
