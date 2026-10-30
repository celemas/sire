<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

/**
 * A rule that names its DSL arguments for message placeholders and issue
 * params, e.g. `['min']` turns `min:18` into `{min}`. Arguments beyond the
 * names keep their positional `{argN}` placeholder.
 *
 * @api
 */
interface NamedArguments extends Rule
{
	/** @var list<non-empty-string> */
	public array $arguments { get; }
}
