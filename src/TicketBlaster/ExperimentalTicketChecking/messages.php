<?php declare(strict_types=1);
/**
 * WARNING! This file has been generated.
 *
 * Modify by changing the underlying DSL. Convention stipulates that the file has an identical filename with a .yaml extension.
 * Are you a first-timer? Ask someone to help you. Have a nice day :-)
 *
 * @see \Infra\EventSourcing\CodeGeneration\MessagesCodeGenerator
 */

namespace TicketBlaster\ExperimentalTicketChecking {

    /**
     * When the `Ticket` has been assigned the right to visit the `Show`
     *
     * @api
     * @category generated
     */
    final class TicketWasIssued implements \Infra\EventSourcing\Event {

        /**
         * @param string $showId
         * @param string $ticketId
         * @param string $issuedAt
         *
         * @api
         */
        function __construct (
            string $showId,
            string $ticketId,
            string $issuedAt
        ) {
            $this->showId = $showId;
            $this->ticketId = $ticketId;
            $this->issuedAt = $issuedAt;
        }

        private const exampleValues = [
            'showId' => 'show:AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA',
            'ticketId' => 'ticket:A43CX2',
            'issuedAt' => '2017-05-09 09:05:02.999999+0000',
        ];

        static function withShowId (string $showId): TicketWasIssued {
            $payload = TicketWasIssued::exampleValues;
            $payload['showId'] = $showId;

            return TicketWasIssued::fromPayload($payload);
        }

        static function fromPayload (array $payload): TicketWasIssued {
            return new TicketWasIssued(
                $payload['showId'],
                $payload['ticketId'],
                $payload['issuedAt']
            );
        }

        function andWithTicketId (string $ticketId): TicketWasIssued {
            $modified = clone $this;
            $modified->ticketId = $ticketId;

            return $modified;
        }

        function andWithIssuedAt (string $issuedAt): TicketWasIssued {
            $modified = clone $this;
            $modified->issuedAt = $issuedAt;

            return $modified;
        }

        private $showId;

        function showId (): string {
            return $this->showId;
        }

        private $ticketId;

        function ticketId (): string {
            return $this->ticketId;
        }

        private $issuedAt;

        function issuedAt (): string {
            return $this->issuedAt;
        }

        function rawMessagePayload (): array {
            return [
                'showId' => $this->showId,
                'ticketId' => $this->ticketId,
                'issuedAt' => $this->issuedAt,
            ];
        }
    }

    /**
     * When the `Ticket` has been used to visit the `Show`
     *
     * @api
     * @category generated
     */
    final class TicketWasUsed implements \Infra\EventSourcing\Event {

        /**
         * @param string $showId
         * @param string $ticketId
         * @param string $usedAt
         *
         * @api
         */
        function __construct (
            string $showId,
            string $ticketId,
            string $usedAt
        ) {
            $this->showId = $showId;
            $this->ticketId = $ticketId;
            $this->usedAt = $usedAt;
        }

        private const exampleValues = [
            'showId' => 'show:AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA',
            'ticketId' => 'ticket:A43CX2',
            'usedAt' => '2017-05-09 09:05:02.999999+0000',
        ];

        static function withShowId (string $showId): TicketWasUsed {
            $payload = TicketWasUsed::exampleValues;
            $payload['showId'] = $showId;

            return TicketWasUsed::fromPayload($payload);
        }

        static function fromPayload (array $payload): TicketWasUsed {
            return new TicketWasUsed(
                $payload['showId'],
                $payload['ticketId'],
                $payload['usedAt']
            );
        }

        function andWithTicketId (string $ticketId): TicketWasUsed {
            $modified = clone $this;
            $modified->ticketId = $ticketId;

            return $modified;
        }

        function andWithUsedAt (string $usedAt): TicketWasUsed {
            $modified = clone $this;
            $modified->usedAt = $usedAt;

            return $modified;
        }

        private $showId;

        function showId (): string {
            return $this->showId;
        }

        private $ticketId;

        function ticketId (): string {
            return $this->ticketId;
        }

        private $usedAt;

        function usedAt (): string {
            return $this->usedAt;
        }

        function rawMessagePayload (): array {
            return [
                'showId' => $this->showId,
                'ticketId' => $this->ticketId,
                'usedAt' => $this->usedAt,
            ];
        }
    }

    /**
     * Check if the `Ticket` may be used to visit the `Show`.
     *
     * @api
     * @category generated
     */
    final class CheckTicket implements \Infra\EventSourcing\Command {

        /**
         * @param string $showId
         * @param string $ticketId
         *
         * @api
         */
        function __construct (
            string $showId,
            string $ticketId
        ) {
            $this->showId = $showId;
            $this->ticketId = $ticketId;
        }

        private $showId;

        function showId (): string {
            return $this->showId;
        }

        private $ticketId;

        function ticketId (): string {
            return $this->ticketId;
        }

        function rawMessagePayload (): array {
            return [
                'showId' => $this->showId,
                'ticketId' => $this->ticketId,
            ];
        }
    }
}
