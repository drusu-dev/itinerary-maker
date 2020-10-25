<?php

declare(strict_types=1);


namespace IM\Models;


use DateTime;

/**
 * Class CustomTicket
 * @package IM\Models
 */
class CustomTicket extends Ticket
{

    /**
     * @var string
     */
    private string $transportMethod;

    /**
     * CustomTicket constructor.
     * @param string $uuid
     * @param DateTime $departureTime
     * @param DateTime $arrivalTime
     * @param string $departureLocation
     * @param string $arrivalLocation
     * @param string $transportMethod
     */
    public function __construct(
        string $uuid,
        DateTime $departureTime,
        DateTime $arrivalTime,
        string $departureLocation,
        string $arrivalLocation,
        string $transportMethod = 'custom'
    ) {
        parent::__construct($uuid, $departureTime, $arrivalTime, $departureLocation, $arrivalLocation);
        $this->transportMethod = $transportMethod;
    }

    public function getInstruction(): string
    {
        return "Take {$this->getTransportMethod()} transport from {$this->getDepartureLocation()} to {$this->getArrivalLocation()}.";
    }

    /**
     * @return string
     */
    public function getTransportMethod(): string
    {
        return $this->transportMethod;
    }
}
