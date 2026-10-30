<?php

declare(strict_types=1);

namespace Celema\Sire\Contract;

/**
 * Implemented next to `Rule` by a rule that must also run for values that
 * are empty after type handling, which other rules skip.
 *
 * @api
 */
interface ValidatesEmpty {}
