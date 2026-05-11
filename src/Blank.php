<?php

declare(strict_types=1);

namespace Celemas\Sire;

/** @api */
enum Blank: string
{
	case Missing = 'missing';
	case Null = 'null';
	case String = 'string';
	case Whitespace = 'whitespace';
	case List = 'list';
}
