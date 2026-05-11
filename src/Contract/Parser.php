<?php

declare(strict_types=1);

namespace Celemas\Sire\Contract;

/** @api */
interface Parser
{
	/**
	 * @return array<array-key, mixed>
	 * @throws \Celemas\Sire\Exception\ValidationError
	 */
	public function parse(array $data): array;
}
