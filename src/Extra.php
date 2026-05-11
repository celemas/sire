<?php

declare(strict_types=1);

namespace Celemas\Sire;

/** @api */
enum Extra: string
{
	case Ignore = 'ignore';
	case Allow = 'allow';
	case Forbid = 'forbid';
}
