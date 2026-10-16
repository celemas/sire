<?php

declare(strict_types=1);

namespace Celema\Sire;

/** @api */
final readonly class Failure
{
	/** @param list<mixed> $args */
	public function __construct(
		public string $key = '',
		public array $args = [],
		public ?string $fallback = null,
	) {}

	public static function key(string $key, mixed ...$args): self
	{
		return new self($key, array_values($args));
	}

	public static function invalid(?string $fallback = null, mixed ...$args): self
	{
		return new self(args: array_values($args), fallback: $fallback);
	}

	public static function message(string $message): self
	{
		return self::invalid(fallback: $message);
	}
}
