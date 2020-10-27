<?php

declare(strict_types=1);

namespace IM\Models;


use DateTime;

/**
 * Abstract class Ticket
 * @package IM\Models
 */
abstract class Ticket implements TicketInterface
{
    /**
     * @var string
     */
    protected string $uuid;
    /**
     * @var DateTime
     */
    protected DateTime $departureTime;
    /**
     * @var DateTime
     */
    protected DateTime $arrivalTime;
    /**
     * @var string
     */
    protected string $departureLocation;
    /**
     * @var string
     */
    protected string $arrivalLocation;

    /**
     * Ticket constructor.
     * @param string $uuid
     * @param DateTime $departureTime
     * @param DateTime $arrivalTime
     * @param string $departureLocation
     * @param string $arrivalLocation
     */
    public function __construct(
        string $uuid,
        DateTime $departureTime,
        DateTime $arrivalTime,
        string $departureLocation,
        string $arrivalLocation
    ) {
        $this->uuid = $uuid;
        $this->departureTime = $departureTime;
        $this->arrivalTime = $arrivalTime;
        $this->departureLocation = $departureLocation;
        $this->arrivalLocation = $arrivalLocation;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return DateTime
     */
    public function getDepartureTime(): DateTime
    {
        return $this->departureTime;
    }

    /**
     * @return DateTime
     */
    public function getArrivalTime(): DateTime
    {
        return $this->arrivalTime;
    }

    /**
     * @return string
     */
    public function getDepartureLocation(): string
    {
        return $this->departureLocation;
    }

    /**
     * @return string
     */
    public function getArrivalLocation(): string
    {
        return $this->arrivalLocation;
    }
}
