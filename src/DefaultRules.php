<?php

declare(strict_types=1);

namespace Celema\Sire;

use Override;

final class DefaultRules implements Contract\RuleRegistry
{
	private const array RULES = [
		'required' => Rule\Required::class,
		'email' => Rule\Email::class,
		'minlen' => Rule\MinLength::class,
		'maxlen' => Rule\MaxLength::class,
		'min' => Rule\Minimum::class,
		'max' => Rule\Maximum::class,
		'regex' => Rule\Regex::class,
		'in' => Rule\Allowed::class,
	];

	/** @var array<string, Contract\Rule> */
	private array $loaded = [];

	#[Override]
	public function get(string $name): ?Contract\Rule
	{
		$class = self::RULES[$name] ?? null;

		return $class === null ? null : ($this->loaded[$name] ??= new $class());
	}

	#[Override]
	public function all(): array
	{
		$rules = [];

		foreach (self::RULES as $name => $class) {
			$this->loaded[$name] ??= new $class();
			$rules[$name] = $this->loaded[$name];
		}

		return $rules;
	}
}
