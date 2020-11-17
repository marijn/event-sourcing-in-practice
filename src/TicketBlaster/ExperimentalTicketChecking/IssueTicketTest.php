<?php declare(strict_types=1);

namespace TicketBlaster\ExperimentalTicketChecking;

use Faker\Factory;
use Infra\EventSourcing\Testing\ProcessManagerTestCase;
use Infra\Standards;
use TicketBlaster\TicketShop\TicketWasSold;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class IssueTicketTest extends ProcessManagerTestCase {

    /**
     * @test
     * @dataProvider provide ticketId showId and issuedAt
     */
    function Issue Ticket when TicketWasSold (
        string $showId,
        string $ticketId,
        string $issuedAt
    ): void {
        $this->scenario
            ->when(
                TicketWasSold
                    ::withTicketId($ticketId)
                    ->andWithShowId($showId)
            )
            ->thenEvent(
                new TicketWasIssued(
                    $showId,
                    $ticketId,
                    $issuedAt
                )
            )
            ->assert(function () { });
    }

    static function provide ticketId showId and issuedAt (): array {
        $faker = Factory::create();

        return [
            'with consistent example data' => [
                'ticketId' => "ticket:{$faker->hexColor}",
                'showId' => "show:{$faker->uuid}",
                'issuedAt' => $faker->dateTimeThisYear('5 seconds ago', 'UTC')->format(Standards::dateTimeFormat),
            ],
        ];
    }
}
