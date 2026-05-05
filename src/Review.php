<?php

declare(strict_types=1);

namespace Duon\Sire;

/** @api */
final readonly class Review
{
	public function __construct(
		private ErrorBag $errors,
		private array $values,
		private bool $list,
	) {}

	/**
	 * @param string|int|list<string|int> $path
	 * @param array<string, mixed> $params
	 */
	public function addError(
		string|int|array $path,
		string $message,
		string $code = 'custom',
		array $params = [],
	): void {
		$this->errors->add(
			self::path($path),
			new Issue([], $code, $message, $params),
		);
	}

	public function isList(): bool
	{
		return $this->list;
	}

	/** @return array<array-key, mixed> */
	public function values(): array
	{
		return $this->values;
	}

	/**
	 * @param string|int|list<string|int> $path
	 * @return list<string|int>
	 */
	private static function path(string|int|array $path): array
	{
		if (is_int($path)) {
			return [$path];
		}

		if (is_string($path)) {
			if ($path === '') {
				return [];
			}

			return self::normalizePath(explode('.', $path));
		}

		return $path;
	}

	/**
	 * @param list<string> $path
	 * @return list<string|int>
	 */
	private static function normalizePath(array $path): array
	{
		return array_map(
			static fn(string $part): string|int => ctype_digit($part) ? (int) $part : $part,
			$path,
		);
	}
}
