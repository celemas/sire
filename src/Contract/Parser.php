<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

/** @api */
interface Parser
{
	/**
	 * @param array<array-key, mixed> $data
	 * @return array<array-key, mixed>
	 * @throws \Celema\Sire\Exception\ValidationError
	 */
	public function parse(array $data): array;
}
