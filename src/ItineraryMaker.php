<?php

declare(strict_types=1);


namespace IM;

use IM\Exceptions\EmptyInputException;
use IM\Exceptions\InvalidInputContentException;
use IM\Exceptions\OverlappingDatesException;
use IM\Models\TicketInterface;

/**
 * Class ItineraryMaker
 * @package IM
 */
class ItineraryMaker
{
    /**
     * @var TicketInterface[]
     */
    private array $tickets;

    /**
     * ItineraryMaker constructor.
     * @param TicketInterface[] $tickets
     * @throws EmptyInputException|InvalidInputContentException
     */
    public function __construct($tickets)
    {
        $this->validateInput($tickets);

        $this->tickets = $tickets;
    }

    /**
     * @param array $tickets
     * @throws EmptyInputException
     * @throws InvalidInputContentException
     */
    private function validateInput(array $tickets): void
    {
        if (empty(array_filter($tickets))) {
            throw new EmptyInputException();
        }

        foreach ($tickets as $ticket) {
            if (!is_a($ticket, TicketInterface::class)) {
                throw new InvalidInputContentException();
            }
        }
    }

    /**
     * @return $this
     * @throws OverlappingDatesException
     */
    public function create(): ItineraryMaker
    {
        $doDateRangesOverlap = static function ($start1, $start2, $end1, $end2) {
            return ($start1 > $start2 ? $start1 : $start2) <= ($end1 < $end2 ? $end1 : $end2);
        };

        usort(
            $this->tickets,
            static function (TicketInterface $first, TicketInterface $second) use ($doDateRangesOverlap) {
                if ($doDateRangesOverlap(
                    $first->getDepartureTime(),
                    $second->getDepartureTime(),
                    $first->getArrivalTime(),
                    $second->getArrivalTime()
                )) {
                    throw new OverlappingDatesException(
                        "Date ranges overlap: 
                    {$first->getUuid()} 
                    and {$second->getUuid()}."
                    );
                }

                return $first->getDepartureTime() <=> $second->getDepartureTime();
            }
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getInstructions(): array
    {
        $instructions[] = 'Start';
        foreach ($this->tickets as $ticket) {
            $instructions[] = $ticket->getInstruction();
        }
        $instructions[] = 'Last destination reached.';

        return $instructions;
    }

    /**
     * @return TicketInterface[]
     */
    public function getTickets(): array
    {
        return $this->tickets;
    }
}
