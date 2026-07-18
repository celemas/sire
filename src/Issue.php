<?php

declare(strict_types=1);

namespace Celema\Sire;

use JsonSerializable;
use Override;

/** @api */
final readonly class Issue implements JsonSerializable
{
	/**
	 * @param list<string|int> $path
	 * @param array<string, mixed> $params
	 */
	public function __construct(
		public array $path,
		public string $code,
		public string $message,
		public array $params = [],
	) {}

	/** @param list<string|int> $prefix */
	public function withPrefix(array $prefix): self
	{
		return new self(
			[...$prefix, ...$this->path],
			$this->code,
			$this->message,
			$this->params,
		);
	}

	/** @return array{path: list<string|int>, code: string, message: string, params: array<string, mixed>} */
	public function toArray(): array
	{
		return [
			'path' => $this->path,
			'code' => $this->code,
			'message' => $this->message,
			'params' => $this->params,
		];
	}

	/** @return array{path: list<string|int>, code: string, message: string, params: array<string, mixed>} */
	#[Override]
	public function jsonSerialize(): array
	{
		return $this->toArray();
	}
}
