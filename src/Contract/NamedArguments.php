<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

/**
 * Implemented next to `Rule` by a rule that names its DSL arguments for
 * message placeholders and issue params, e.g. `['min']` turns `min:18` into
 * `{min}`. Arguments beyond the names keep their positional `{argN}`.
 *
 * @api
 */
interface NamedArguments
{
	/** @var list<non-empty-string> */
	public array $arguments { get; }
}
