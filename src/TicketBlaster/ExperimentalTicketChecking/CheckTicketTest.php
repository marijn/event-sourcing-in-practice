<?php declare(strict_types=1);

namespace TicketBlaster\ExperimentalTicketChecking;

use Faker\Factory;
use Infra\EventSourcing\Testing\EventSourcedCommandHandlerTestCase;
use Infra\Standards;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class CheckTicketTest extends EventSourcedCommandHandlerTestCase {

    /**
     * @test
     * @dataProvider provide showId ticketId and usedAt
     */
    function Ticket Holder presents issued Ticket that has NOT been used (
        string $showId,
        string $ticketId,
        string $usedAt
    ): void {
        $this->scenario
            ->given(
                TicketWasIssued
                    ::withShowId($showId)
                    ->andWithTicketId($ticketId)
            )
            ->when(
                new CheckTicket(
                    $showId,
                    $ticketId
                )
            )
            ->then(
                new TicketWasUsed(
                    $showId,
                    $ticketId,
                    $usedAt
                )
            )
            ->assert();
    }

    /**
     * @test
     * @dataProvider provide showId ticketId and checkedAt
     */
    function Ticket Holder presents Ticket that has NOT been issued (
        string $showId,
        string $ticketId,
        string $checkedAt
    ): void {
        $this->scenario
            ->when(
                new CheckTicket(
                    $showId,
                    $ticketId
                )
            )
            ->then(
                new CounterfeitTicketChecked(
                    $showId,
                    $ticketId,
                    $checkedAt
                )
            )
            ->assert();
    }

    /** @test */
    function Ticket Holder presents issued Ticket that has been used before (): void {
        self::markTestIncomplete();
    }

    /** @test */
    function Ticket Holder presents issued Ticket that has been used 2 seconds earlier (): void {
        self::markTestIncomplete();
    }

    static function provide showId ticketId and usedAt (): array {
        $faker = Factory::create();

        return [
            'with consistent example data' => [
                'showId' => "show:{$faker->uuid}",
                'ticketId' => "ticket:{$faker->hexColor}",
                'usedAt' => $faker->dateTimeThisYear('5 seconds ago', 'UTC')->format(Standards::dateTimeFormat),
            ],
        ];
    }

    static function provide showId ticketId and checkedAt (): array {
        $faker = Factory::create();

        return [
            'with consistent example data' => [
                'showId' => "show:{$faker->uuid}",
                'ticketId' => "ticket:{$faker->hexColor}",
                'checkedAt' => $faker->dateTimeThisYear('5 seconds ago', 'UTC')->format(Standards::dateTimeFormat),
            ],
        ];
    }
}
