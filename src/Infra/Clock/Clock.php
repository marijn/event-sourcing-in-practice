<?php declare(strict_types=1);

namespace Infra\Clock;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
interface Clock {

    function now (): PointInTime;
}
