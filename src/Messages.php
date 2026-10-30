<?php

declare(strict_types=1);

namespace Celema\Sire;

/** @internal */
final class Messages
{
	public const string EXTRA = 'Field "{field}" is not allowed';
	public const string MISSING = '{label} is required';
	public const string NULL = '{label} must not be null';
	public const string SHAPE = '{label} must be an array';

	/** @return array<string, string> Every message key with its default template, sorted by key. */
	public static function defaults(Contract\RuleRegistry $rules, Contract\CoercerRegistry $coercers): array
	{
		$messages = [
			'extra' => self::EXTRA,
			'missing' => self::MISSING,
			'null' => self::NULL,
			'type.shape' => self::SHAPE,
		];

		foreach ($coercers->all() as $name => $coercer) {
			$messages['type.' . $name] = $coercer->message;
		}

		foreach ($rules->all() as $name => $rule) {
			$messages['rule.' . $name] = $rule->message;
		}

		ksort($messages, SORT_STRING);

		return $messages;
	}
}
