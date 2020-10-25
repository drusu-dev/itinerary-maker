<?php

declare(strict_types=1);


namespace IM\Models;


use DateTime;

/**
 * Class AirplaneTicket
 * @package IM\Models
 */
class AirplaneTicket extends Ticket
{
    /**
     * @var string
     */
    private string $seat;
    /**
     * @var string
     */
    private string $gate;
    private string $flightNumber;

    /**
     * AirplaneTicket constructor.
     * @param string $uuid
     * @param DateTime $departureTime
     * @param DateTime $arrivalTime
     * @param string $departureLocation
     * @param string $arrivalLocation
     * @param string $seat
     * @param string $gate
     * @param string $flightNumber
     */
    public function __construct(
        string $uuid,
        DateTime $departureTime,
        DateTime $arrivalTime,
        string $departureLocation,
        string $arrivalLocation,
        string $seat,
        string $gate,
        string $flightNumber
    ) {
        parent::__construct($uuid, $departureTime, $arrivalTime, $departureLocation, $arrivalLocation);
        $this->seat = $seat;
        $this->gate = $gate;
        $this->flightNumber = $flightNumber;
    }

    /**
     * @return string
     */
    public function getTransportMethod(): string
    {
        return 'Airplane';
    }

    public function getInstruction(): string
    {
        return "From {$this->getDepartureLocation()}, board flight {$this->getFlightNumber()} to {$this->getArrivalLocation()} from gate {$this->getGate()}, seat {$this->getSeat()}.";
    }

    public function getFlightNumber()
    {
        return $this->flightNumber;
    }

    /**
     * @return string
     */
    public function getGate(): string
    {
        return $this->gate;
    }

    /**
     * @return string
     */
    public function getSeat(): string
    {
        return $this->seat;
    }
}
