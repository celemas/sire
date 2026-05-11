<?php

declare(strict_types=1);

namespace Celemas\Sire\Tests;

use Celemas\Sire\Contract;
use Celemas\Sire\Result;
use Celemas\Sire\Shape;
use Override;

final class SubShape implements Contract\Validator
{
	private Shape $shape;

	public function __construct(bool $list = false)
	{
		$this->shape = $list ? Shape::list() : new Shape();
		$this->shape->add('inner_int', 'int')->rules('required')->label('Int');
		$this->shape->add('inner_email', 'string')->rules('required', 'email')->label('Email');
	}

	#[Override]
	public function validate(array $data): Result
	{
		return $this->shape->validate($data);
	}
}
