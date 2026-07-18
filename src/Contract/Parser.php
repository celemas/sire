<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

/** @api */
interface Parser
{
	/**
	 * @return array<array-key, mixed>
	 * @throws \Celema\Sire\Exception\ValidationError
	 */
	public function parse(array $data): array;
}
