<?php declare(strict_types=1);
/**
 * WARNING! This file has been generated.
 *
 * Modify by changing the underlying DSL. Convention stipulates that the file has an identical filename with a .yaml extension.
 * Are you a first-timer? Ask someone to help you. Have a nice day :-)
 *
 * @see \Infra\EventSourcing\CodeGeneration\MessagesCodeGenerator
 */

namespace TicketBlaster\TicketShop {

    /**
     * @api
     * @category generated
     */
    final class TicketWasSold implements \Infra\EventSourcing\Event {

        /**
         * @param string $ticketId
         * @param string $showId
         * @param string $soldAt
         *
         * @api
         */
        function __construct (
            string $ticketId,
            string $showId,
            string $soldAt
        ) {
            $this->ticketId = $ticketId;
            $this->showId = $showId;
            $this->soldAt = $soldAt;
        }

        private const exampleValues = [
            'ticketId' => 'ticket:A43CX2',
            'showId' => 'show:AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA',
            'soldAt' => '2017-04-12 12:12:01.999999+0000',
        ];

        static function withTicketId (string $ticketId): TicketWasSold {
            $payload = TicketWasSold::exampleValues;
            $payload['ticketId'] = $ticketId;

            return TicketWasSold::fromPayload($payload);
        }

        static function fromPayload (array $payload): TicketWasSold {
            return new TicketWasSold(
                $payload['ticketId'],
                $payload['showId'],
                $payload['soldAt']
            );
        }

        function andWithShowId (string $showId): TicketWasSold {
            $modified = clone $this;
            $modified->showId = $showId;

            return $modified;
        }

        function andWithSoldAt (string $soldAt): TicketWasSold {
            $modified = clone $this;
            $modified->soldAt = $soldAt;

            return $modified;
        }

        private $ticketId;

        function ticketId (): string {
            return $this->ticketId;
        }

        private $showId;

        function showId (): string {
            return $this->showId;
        }

        private $soldAt;

        function soldAt (): string {
            return $this->soldAt;
        }

        function rawMessagePayload (): array {
            return [
                'ticketId' => $this->ticketId,
                'showId' => $this->showId,
                'soldAt' => $this->soldAt,
            ];
        }
    }
}
