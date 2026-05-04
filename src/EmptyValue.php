<?php

declare(strict_types=1);

namespace Duon\Sire;

/** @api */
enum EmptyValue: string
{
	case Missing = 'missing';
	case Null = 'null';
	case String = 'string';
	case Whitespace = 'whitespace';
	case List = 'list';
}
