<?php

declare(strict_types=1);

namespace Celema\Sire;

/** @internal */
final class Arguments
{
	/**
	 * Gives rule arguments the names their rule declares, by position.
	 *
	 * @param list<string> $args
	 * @return array<array-key, string>
	 */
	public static function named(array $args, Contract\NamedArguments $rule): array
	{
		$names = $rule->arguments;
		$named = [];

		foreach ($args as $index => $arg) {
			$named[$names[$index] ?? $index] = $arg;
		}

		return $named;
	}

	/**
	 * Placeholder names: a named argument keeps its name, a positional one
	 * becomes `argN` by its position.
	 *
	 * @template T
	 * @param array<array-key, T> $args
	 * @return array<string, T>
	 */
	public static function keyed(array $args): array
	{
		$keyed = [];

		foreach ($args as $key => $arg) {
			$keyed[is_int($key) ? 'arg' . ($key + 1) : $key] = $arg;
		}

		return $keyed;
	}
}
