<?php

namespace IM;

use DateTime;
use IM\Models\AirplaneTicket;
use IM\Models\BusTicket;
use IM\Models\CustomTicket;
use IM\Models\TicketInterface;
use PHPUnit\Framework\TestCase;

class TicketTest extends TestCase
{
    /**
     * @dataProvider ticketDataProvider
     * @param $uuid
     * @param $departureTime
     * @param $arrivalTime
     * @param $departureLocation
     * @param $arrivalLocation
     */
    public function testCanCreateTicket(
        $uuid,
        $departureTime,
        $arrivalTime,
        $departureLocation,
        $arrivalLocation
    ): void {
        $this->assertInstanceOf(
            TicketInterface::class,
            new CustomTicket(
                $uuid,
                $departureTime,
                $arrivalTime,
                $departureLocation,
                $arrivalLocation
            )
        );
    }

    /**
     * @dataProvider ticketDataProvider
     * @param $uuid
     * @param $departureTime
     * @param $arrivalTime
     * @param $departureLocation
     * @param $arrivalLocation
     */
    public function testCanRetrieveTicketData(
        $uuid,
        $departureTime,
        $arrivalTime,
        $departureLocation,
        $arrivalLocation
    ): void {
        $ticket = new CustomTicket(
            $uuid,
            $departureTime,
            $arrivalTime,
            $departureLocation,
            $arrivalLocation
        );

        $this->assertEquals('773-C8D3', $ticket->getUuid());
        $this->assertEquals(new DateTime('2020-10-21 10:45:00'), $ticket->getDepartureTime());
        $this->assertEquals(new DateTime('2020-10-21 14:12:00'), $ticket->getArrivalTime());
        $this->assertEquals('Bucharest', $ticket->getDepartureLocation());
        $this->assertEquals('London', $ticket->getArrivalLocation());
    }

    public function testCreateAirplaneTicket(): void
    {
        $airplaneTicket = new AirplaneTicket(
            'NDY1SH',
            new DateTime('2015-10-29 11:10:00'),
            new DateTime('2015-10-29 16:20:00'),
            'London',
            'Bucharest',
            '12A',
            '22',
            'GP8971'
        );

        $this->assertEquals('12A', $airplaneTicket->getSeat());
        $this->assertEquals('22', $airplaneTicket->getGate());
        $this->assertEquals('Airplane', $airplaneTicket->getTransportMethod());
        $this->assertEquals('GP8971', $airplaneTicket->getFlightNumber());
    }

    public function testCreateBusTicket(): void
    {
        $busTicket = new BusTicket(
            '2119723',
            new DateTime('2015-10-29 11:10:00'),
            new DateTime('2015-10-29 16:20:00'),
            'Pall Mall St James Palace',
            'Temple Avenue',
            '734'
        );

        $this->assertEquals('Bus', $busTicket->getTransportMethod());
        $this->assertEquals('734', $busTicket->getBusNumber());
    }

    /**
     * @return array[]
     */
    public function ticketDataProvider(): array
    {
        return [
            'full ticket' => [
                '773-C8D3',
                new DateTime('2020-10-21 10:45:00'),
                new DateTime('2020-10-21 14:12:00'),
                'Bucharest',
                'London',
            ]
        ];
    }
}
