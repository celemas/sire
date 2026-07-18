<?php

declare(strict_types=1);

namespace Celema\Sire;

/** @api */
final readonly class Coercion implements Contract\Coercion
{
	public function __construct(
		public mixed $value,
		public mixed $pristine,
		public ?Failure $failure = null,
		public bool $empty = false,
	) {}
}
