<?php declare(strict_types=1);

namespace Infra\Clock;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class ClockForTesting implements Clock
{
    private $pointInTime;

    function __construct(PointInTime $pointInTime)
    {
        $this->pointInTime = $pointInTime;
    }

    function setTime(PointInTime $newTime)
    {
        $this->pointInTime = $newTime;
    }

    function now(): PointInTime
    {
        return $this->pointInTime;
    }
}
