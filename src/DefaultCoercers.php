<?php

declare(strict_types=1);

namespace Celema\Sire;

use Override;

final class DefaultCoercers implements Contract\CoercerRegistry
{
	private const array COERCERS = [
		'string' => Coercer\Str::class,
		'bool' => Coercer\Boolean::class,
		'list' => Coercer\ListArray::class,
		'float' => Coercer\FloatingPoint::class,
		'int' => Coercer\Integer::class,
		'number' => Coercer\Number::class,
	];

	/** @var array<string, Contract\Coercer> */
	private array $loaded = [];

	#[Override]
	public function get(string $name): ?Contract\Coercer
	{
		$class = self::COERCERS[$name] ?? null;

		return $class === null ? null : ($this->loaded[$name] ??= new $class());
	}

	#[Override]
	public function all(): array
	{
		$coercers = [];

		foreach (self::COERCERS as $name => $class) {
			$this->loaded[$name] ??= new $class();
			$coercers[$name] = $this->loaded[$name];
		}

		return $coercers;
	}
}
