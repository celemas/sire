<?php

declare(strict_types=1);

namespace Celemas\Sire\Exception;

use Celemas\Sire\Result;
use RuntimeException;
use Throwable;

/** @api */
final class ValidationError extends RuntimeException
{
	public function __construct(
		private readonly Result $result,
		string $message = 'Validation failed',
		int $code = 0,
		?Throwable $previous = null,
	) {
		parent::__construct($message, $code, $previous);
	}

	public function result(): Result
	{
		return $this->result;
	}
}
