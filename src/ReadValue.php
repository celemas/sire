<?php

declare(strict_types=1);

namespace Celemas\Sire;

/** @internal */
final readonly class ReadValue
{
	public function __construct(
		public Contract\Value $value,
		public ?Issue $issue = null,
		public ?Result $nestedResult = null,
	) {}
}
