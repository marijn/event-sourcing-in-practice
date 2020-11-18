<?php declare(strict_types=1);

namespace Infra\Clock;

use DateTimeImmutable;
use DateTimeZone;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class PointInTime
{
    /**
     * @private
     */
    const FORMAT_OF_TIME = 'Y-m-d H:i:s.uO';

    private $time;

    function __construct(DateTimeImmutable $time)
    {
        $this->time = $time->setTimezone(new DateTimeZone('UTC'));
    }

    static function fromString(string $time): PointInTime
    {
        $dateTime = DateTimeImmutable::createFromFormat(PointInTime::FORMAT_OF_TIME, $time);

        if ( ! $dateTime)
        {
            throw InvalidPointInTimeFormat::withTimeString($time);
        }

        return new PointInTime($dateTime);
    }

    static function epoch () {
        return PointInTime::fromString("1970-01-01 00:00:00.000000+0000");
    }

    function time(): DateTimeImmutable
    {
        return $this->time;
    }

    function __toString(): string
    {
        return $this->time->format(PointInTime::FORMAT_OF_TIME);
    }

    function format(string $format) : string {
        return $this->time->format($format);
    }

    function isBefore (PointInTime $anotherTime): bool { return $this->time < $anotherTime->time; }
}

final class InvalidPointInTimeFormat extends \InvalidArgumentException
{
    static function withTimeString(string $dateTime): InvalidPointInTimeFormat
    {
        return new InvalidPointInTimeFormat(sprintf('Date time could not be created from %s', $dateTime));
    }
}
