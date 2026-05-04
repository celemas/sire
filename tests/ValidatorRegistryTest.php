<?php

declare(strict_types=1);

namespace Duon\Sire\Tests;

use Duon\Sire\Contract;
use Duon\Sire\Validation;
use Duon\Sire\ValidatorRegistry;
use Duon\Sire\Value;
use Override;
use RuntimeException;

class ValidatorRegistryTest extends TestCase
{
	public function testWithManyAddsValidators(): void
	{
		$registry = new ValidatorRegistry();

		$updatedRegistry = $registry->withMany([
			'starts_with' => self::stringValidator(),
			'ends_with' => self::stringValidator(),
		]);

		$this->assertNull($registry->get('starts_with'));
		$this->assertSame($updatedRegistry->get('starts_with'), $updatedRegistry->get('starts_with'));
		self::assertValid(self::validator($updatedRegistry, 'ends_with'), new Value('value', 'value'));
	}

	public function testWithManyHandlesEmptyInput(): void
	{
		$registry = ValidatorRegistry::withDefaults();
		$updatedRegistry = $registry->withMany([]);

		$this->assertSame($registry->get('required'), $updatedRegistry->get('required'));
	}

	public function testWithDefaultsFindsBuiltInValidators(): void
	{
		$registry = ValidatorRegistry::withDefaults();

		self::assertValid(self::validator($registry, 'required'), new Value('value', 'value'));
		self::assertValid(
			self::validator($registry, 'email'),
			new Value('test@example.com', 'test@example.com'),
		);
		self::assertValid(self::validator($registry, 'minlen'), new Value('abc', 'abc'), '2');
		self::assertValid(self::validator($registry, 'maxlen'), new Value('abc', 'abc'), '3');
		self::assertValid(self::validator($registry, 'min'), new Value(5, 5), '1');
		self::assertValid(self::validator($registry, 'max'), new Value(5, 5), '10');
		self::assertValid(self::validator($registry, 'regex'), new Value('abc', 'abc'), '/^abc$/');
		self::assertValid(self::validator($registry, 'in'), new Value('a', 'a'), 'a,b');
	}

	public function testWithDefaultsMemoizesBuiltInValidators(): void
	{
		$registry = ValidatorRegistry::withDefaults();

		$this->assertSame($registry->get('required'), $registry->get('required'));
	}

	public function testWithDefaultsReturnsNullForUnknownValidators(): void
	{
		$registry = ValidatorRegistry::withDefaults();

		$this->assertNull($registry->get('unknown'));
	}

	public function testCustomValidatorShadowsDefaults(): void
	{
		$validator = self::stringValidator();
		$registry = ValidatorRegistry::withDefaults()->with('required', $validator);

		$this->assertSame($validator, $registry->get('required'));
	}

	public function testLocalValidatorShadowsFallback(): void
	{
		$fallback = new class implements Contract\ValidatorRegistry {
			#[Override]
			public function get(string $name): ?Contract\Validator
			{
				throw new RuntimeException('Fallback should not be queried');
			}
		};

		$validator = self::stringValidator();
		$registry = new ValidatorRegistry(['required' => $validator], $fallback);

		$this->assertSame($validator, $registry->get('required'));
	}

	private static function validator(ValidatorRegistry $registry, string $name): Contract\Validator
	{
		return (
			$registry->get($name) ?? throw new RuntimeException(sprintf('Missing validator "%s"', $name))
		);
	}

	private static function assertValid(
		Contract\Validator $validator,
		Value $value,
		string ...$args,
	): void {
		self::assertNull($validator->validate($value, ...$args)->failure);
	}

	private static function stringValidator(): Contract\Validator
	{
		return new class implements Contract\Validator {
			public string $message {
				get => 'Must match';
			}

			#[Override]
			public function validate(Contract\Value $value, string ...$args): Contract\Validation
			{
				return Validation::from(is_string($value->value));
			}
		};
	}
}
