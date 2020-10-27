<?php

declare(strict_types=1);

namespace IM\Models;


use DateTime;

/**
 * Interface TicketInterface
 * @package IM\Models
 */
interface TicketInterface
{
    /**
     * @return string
     */
    public function getArrivalLocation(): string;

    /**
     * @return DateTime
     */
    public function getArrivalTime(): DateTime;

    /**
     * @return string
     */
    public function getDepartureLocation(): string;

    /**
     * @return DateTime
     */
    public function getDepartureTime(): DateTime;

    /**
     * @return string
     */
    public function getUuid(): string;

    /**
     * @return string
     */
    public function getInstruction(): string;
}
