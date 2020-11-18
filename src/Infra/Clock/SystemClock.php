<?php declare(strict_types=1);

namespace Infra\Clock;

use DateTimeImmutable;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class SystemClock implements Clock
{
    function now(): PointInTime
    {
        return new PointInTime(DateTimeImmutable::createFromFormat('U.u', sprintf('%.6f', microtime(true))));
    }
}
