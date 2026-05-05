<?php

declare(strict_types=1);

namespace Duon\Sire\Contract;

/** @api */
interface Parser
{
	/**
	 * @return array<array-key, mixed>
	 * @throws \Duon\Sire\Exception\ValidationError
	 */
	public function parse(array $data): array;
}
