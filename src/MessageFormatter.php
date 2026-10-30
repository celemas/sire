<?php

declare(strict_types=1);

namespace Celema\Sire;

use Stringable;

/** @api */
final readonly class MessageFormatter
{
	/** @param array<string, string> $messages */
	public function __construct(
		private array $messages,
	) {}

	/**
	 * Templates use `{label}`, `{field}`, `{value}`, and the failure or rule
	 * arguments: named ones by their name, positional ones as `{argN}`.
	 *
	 * @param array<array-key, mixed> $args
	 * @param array<string, string> $messages
	 */
	public function format(
		Failure $failure,
		string $label,
		string $field,
		mixed $pristine,
		?string $defaultKey = null,
		string $fallback = '{label} is invalid',
		array $args = [],
		array $messages = [],
	): string {
		$template = $this->template($failure, $defaultKey, $fallback, $messages);
		$args = $failure->args === [] ? $args : $failure->args;

		return self::render($template, $label, $field, $pristine, $args);
	}

	/** @param array<string, string> $messages */
	private function template(
		Failure $failure,
		?string $defaultKey,
		string $fallback,
		array $messages,
	): string {
		if ($failure->key !== '' && array_key_exists($failure->key, $messages)) {
			return $messages[$failure->key];
		}

		if ($defaultKey !== null && array_key_exists($defaultKey, $messages)) {
			return $messages[$defaultKey];
		}

		if ($failure->key !== '' && array_key_exists($failure->key, $this->messages)) {
			return $this->messages[$failure->key];
		}

		if ($defaultKey !== null && array_key_exists($defaultKey, $this->messages)) {
			return $this->messages[$defaultKey];
		}

		return $failure->fallback ?? $fallback;
	}

	/** @param array<array-key, mixed> $args */
	private static function render(
		string $template,
		string $label,
		string $field,
		mixed $pristine,
		array $args,
	): string {
		$values = self::placeholders(
			$label,
			$field,
			self::stringify($pristine),
			array_map(self::stringify(...), $args),
		);
		$rendered = preg_replace_callback(
			'/{{|}}|{([^{}]+)}/',
			static function (array $matches) use ($values): string {
				$token = $matches[0];

				return match ($token) {
					'{{' => '{',
					'}}' => '}',
					default => $values[$matches[1] ?? ''] ?? $token,
				};
			},
			$template,
		);

		return $rendered ?? $template;
	}

	/**
	 * Label, field, and value win over arguments of the same name.
	 *
	 * @param array<array-key, string> $args
	 * @return array<string, string>
	 */
	private static function placeholders(
		string $label,
		string $field,
		string $value,
		array $args,
	): array {
		return [
			...Arguments::keyed($args),
			'label' => $label,
			'field' => $field,
			'value' => $value,
		];
	}

	private static function stringify(mixed $value): string
	{
		return $value instanceof Stringable ? (string) $value : print_r($value, true);
	}
}
