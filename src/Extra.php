<?php

declare(strict_types=1);

namespace Celema\Sire;

/** @api */
enum Extra: string
{
	case Ignore = 'ignore';
	case Allow = 'allow';
	case Forbid = 'forbid';
}
