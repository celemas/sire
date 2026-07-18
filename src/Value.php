<?php

declare(strict_types=1);

namespace Celema\Sire;

/** @api */
final class Value implements Contract\Value
{
	public function __construct(
		public readonly mixed $value,
		public readonly mixed $pristine,
		public readonly bool $empty = false,
	) {}
}
