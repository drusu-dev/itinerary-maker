<?php

namespace IM;

use DateTime;
use IM\Exceptions\EmptyInputException;
use IM\Exceptions\InvalidInputContentException;
use IM\Exceptions\OverlappingDatesException;
use IM\Models\AirplaneTicket;
use IM\Models\BusTicket;
use IM\Models\CustomTicket;
use PHPUnit\Framework\TestCase;

class ItineraryMakerTest extends TestCase
{
    /**
     * @dataProvider ticketsDataProvider
     * @param $input
     * @param $expect
     * @throws EmptyInputException|OverlappingDatesException|InvalidInputContentException
     */
    public function testCreateWithDifferentTypesOfTickets($input, $expect): void
    {
        $im = new ItineraryMaker($input);
        $im->create();

        $this->assertEquals($expect, $im->getTickets());
    }

    public function ticketsDataProvider(): array
    {
        return [
            'All custom tickets' => [
                'input' =>  [
                    new CustomTicket('4', new DateTime('2020-01-29 01:00:00'), new DateTime('2020-01-29 03:55:00'), 'somewhere', 'nextwhere', 'spaceship'),
                    new CustomTicket('3', new DateTime('2020-01-17 13:30:00'), new DateTime('2020-01-17 15:20:00'), 'somewhere', 'nextwhere'),
                    new CustomTicket('1', new DateTime('2020-01-02 17:35:00'), new DateTime('2020-01-02 19:48:00'), 'somewhere', 'nextwhere', 'taxi'),
                    new CustomTicket('2', new DateTime('2020-01-02 20:35:00'), new DateTime('2020-01-02 21:40:00'), 'somewhere', 'nextwhere', 'carpet'),
                ],
                'expect' => [
                    new CustomTicket('1', new DateTime('2020-01-02 17:35:00'), new DateTime('2020-01-02 19:48:00'), 'somewhere', 'nextwhere', 'taxi'),
                    new CustomTicket('2', new DateTime('2020-01-02 20:35:00'), new DateTime('2020-01-02 21:40:00'), 'somewhere', 'nextwhere', 'carpet'),
                    new CustomTicket('3', new DateTime('2020-01-17 13:30:00'), new DateTime('2020-01-17 15:20:00'), 'somewhere', 'nextwhere'),
                    new CustomTicket('4', new DateTime('2020-01-29 01:00:00'), new DateTime('2020-01-29 03:55:00'), 'somewhere', 'nextwhere', 'spaceship'),
                ],
                'expectInstructions' => [
                    'Start',
                    'Take your taxi transport from somewhere to nextwhere.',
                    'Take your carpet transport from somewhere to nextwhere.',
                    'Take your custom transport from somewhere to nextwhere.',
                    'Take your spaceship transport from somewhere to nextwhere.',
                    'Last destination reached.'
                ]
            ],
            'various tickets' => [
                'input' =>  [
                    new AirplaneTicket('4', new DateTime('2020-01-29 01:00:00'), new DateTime('2020-01-29 03:55:00'), 'somewhere', 'nextwhere', '13C', '22', 'AG6547'),
                    new BusTicket('3', new DateTime('2020-01-17 13:30:00'), new DateTime('2020-01-17 15:20:00'), 'somewhere', 'nextwhere', '112'),
                    new CustomTicket('1', new DateTime('2020-01-02 17:35:00'), new DateTime('2020-01-02 19:48:00'), 'somewhere', 'nextwhere'),
                    new CustomTicket('2', new DateTime('2020-01-02 20:35:00'), new DateTime('2020-01-02 21:40:00'), 'somewhere', 'nextwhere'),
                ],
                'expect' => [
                    new CustomTicket('1', new DateTime('2020-01-02 17:35:00'), new DateTime('2020-01-02 19:48:00'), 'somewhere', 'nextwhere'),
                    new CustomTicket('2', new DateTime('2020-01-02 20:35:00'), new DateTime('2020-01-02 21:40:00'), 'somewhere', 'nextwhere'),
                    new BusTicket('3', new DateTime('2020-01-17 13:30:00'), new DateTime('2020-01-17 15:20:00'), 'somewhere', 'nextwhere', '112'),
                    new AirplaneTicket('4', new DateTime('2020-01-29 01:00:00'), new DateTime('2020-01-29 03:55:00'), 'somewhere', 'nextwhere', '13C', '22', 'AG6547'),
                ],
                'expectInstructions' => [
                    'Start',
                    'Take your custom transport from somewhere to nextwhere.',
                    'Take your custom transport from somewhere to nextwhere.',
                    'Board the Bus 112 from somewhere to nextwhere',
                    'From somewhere, board flight AG6547 to nextwhere from gate 22, seat 13C.',
                    'Last destination reached.',
                ]
            ]
        ];
    }


    /**
     * @dataProvider emptyInputExceptionDataProvider
     * @param $input
     * @param $expect
     * @throws EmptyInputException
     * @throws InvalidInputContentException
     */
    public function testEmptyInputException($input, $expect): void
    {
        $this->expectExceptionObject(new $expect);
        new ItineraryMaker($input);
    }


    public function emptyInputExceptionDataProvider(): array
    {
        return [
            'Empty input should throw EmptyInputException' => [
                'input' =>  [],
                'expect' => EmptyInputException::class
            ],
            'Empty strings should throw EmptyInputException' => [
                'input' =>  ['', '', ''],
                'expect' => EmptyInputException::class
            ]
        ];
    }

    /**
     * @dataProvider invalidInputContentExceptionDataProvider
     * @param $input
     * @param $expect
     * @throws EmptyInputException
     * @throws OverlappingDatesException|InvalidInputContentException
     */
    public function testInvalidInputContentException($input, $expect): void
    {
        $this->expectException($expect);

        $im = new ItineraryMaker($input);
        $im->create();
    }

    public function invalidInputContentExceptionDataProvider(): array
    {
        return [
            'primitives' => [
                'input'=> ['1', 23, 'London','13:33'],
                'expect' => InvalidInputContentException::class
            ],
            'combination of tickets and primitives' => [
                'input' => [
                    new AirplaneTicket('NDY1SH', new DateTime('2020-10-21 10:00:00'), new DateTime('2020-10-21 13:00:00'), 'somewhere', 'nextwhere', '12B', '07', 'GP8971'),
                    ['NDY1SH', new DateTime('2020-10-21 10:00:00'), new DateTime('2020-10-21 13:00:00'), 'somewhere', 'nextwhere', '12B', '07', 'GP8971']
                ],
                'expect' => InvalidInputContentException::class
            ]
        ];

    }

    /**
     * @dataProvider overlappingDatesExceptionDataProvider
     * @param $input
     * @param $expect
     * @throws EmptyInputException|OverlappingDatesException|InvalidInputContentException
     */
    public function testOverlappingDatesException($input, $expect): void
    {
        $this->expectException($expect);

        $im = new ItineraryMaker($input);
        $im->create();
    }

    public function overlappingDatesExceptionDataProvider(): array
    {
        return [
            'arrival time overlaps with departure time' => [
                'input' => [
                    new AirplaneTicket('NDY1SH', new DateTime('2020-10-21 10:00:00'), new DateTime('2020-10-21 13:00:00'), 'somewhere', 'nextwhere', '12B', '07', 'GP8971'),
                    new AirplaneTicket('FGX8DN', new DateTime('2020-10-21 12:00:00'), new DateTime('2020-10-21 16:00:00'), 'somewhere', 'nextwhere', '18C', '18', 'GP8971'),
                ],
                'expect' => OverlappingDatesException::class
            ],
            'second ticket happens during first one' => [
                'input' => [
                    new AirplaneTicket('NDY1SH', new DateTime('2020-10-21 10:00:00'), new DateTime('2020-10-21 22:00:00'), 'somewhere', 'nextwhere', '12B', '07', 'GP8971'),
                    new AirplaneTicket('FGX8DN', new DateTime('2020-10-21 12:00:00'), new DateTime('2020-10-21 16:00:00'), 'somewhere', 'nextwhere', '18C', '18', 'GP8971'),
                ],
                'expect' => OverlappingDatesException::class
            ]
        ];
    }


    /**
     * @dataProvider ticketsDataProvider
     * @param $input
     * @param $expect
     * @param $expectInstructions
     * @throws EmptyInputException
     * @throws InvalidInputContentException
     * @throws OverlappingDatesException
     */
    public function testItineraryInstructions($input, $expect, $expectInstructions): void
    {
        $im = (new ItineraryMaker($input))->create();
        $instructions = $im->getInstructions();

        $this->assertEquals($expectInstructions, $instructions);
    }

    /**
     * @dataProvider ticketsDataProvider
     * @param $input
     * @throws EmptyInputException
     * @throws InvalidInputContentException
     * @throws OverlappingDatesException
     */
    public function testInputOutputShouldBeCompatible($input): void
    {
        $im = new ItineraryMaker($input);
        $im->create();
        $output = $im->getTickets();

        $newIm = new ItineraryMaker($output);
        $newIm->create();

        $this->assertTrue(true);
    }
}
