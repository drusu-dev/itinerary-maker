<?php

declare(strict_types=1);

namespace IM\Models;


use DateTime;

/**
 * Class BusTicket
 * @package IM\Models
 */
class BusTicket extends Ticket
{
    /**
     * @var string
     */
    private string $busNumber;

    /**
     * BusTicket constructor.
     * @param string $uuid
     * @param DateTime $departureTime
     * @param DateTime $arrivalTime
     * @param string $departureLocation
     * @param string $arrivalLocation
     * @param string $busNumber
     */
    public function __construct(
        string $uuid,
        DateTime $departureTime,
        DateTime $arrivalTime,
        string $departureLocation,
        string $arrivalLocation,
        string $busNumber
    ) {
        parent::__construct($uuid, $departureTime, $arrivalTime, $departureLocation, $arrivalLocation);
        $this->busNumber = $busNumber;
    }

    public function getInstruction(): string
    {
        return "Board the Bus {$this->busNumber} from {$this->departureLocation} to {$this->arrivalLocation}";
    }
}
