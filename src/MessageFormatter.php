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
	 * Message templates receive label, field, pristine value, then failure or rule arguments.
	 * Named arguments render as their own placeholder, positional ones as `{argN}`.
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
		$value = self::stringify($pristine);
		$args = array_map(self::stringify(...), $args);
		$placeholders = self::placeholders($label, $field, $value, $args);

		if (self::usesNamedTemplate($template, $placeholders)) {
			return self::renderNamed($template, $placeholders);
		}

		return sprintf($template, $label, $field, $value, ...array_values($args));
	}

	/** @param array<string, string> $values */
	private static function renderNamed(string $template, array $values): string
	{
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

	/** @param array<string, string> $placeholders */
	private static function usesNamedTemplate(string $template, array $placeholders): bool
	{
		if (
			str_contains($template, '{{')
			|| str_contains($template, '}}')
			|| preg_match('/{arg[1-9][0-9]*}/', $template) === 1
		) {
			return true;
		}

		foreach (array_keys($placeholders) as $name) {
			if (str_contains($template, '{' . $name . '}')) {
				return true;
			}
		}

		return false;
	}
}
