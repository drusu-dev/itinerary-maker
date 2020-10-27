## About
Discovers itinerary based on tickets and can return a step by step instruction list.


## Composer

```composer require drusu-dev/itinerary-maker```

## Getting Started

Initialize ItineraryMaker with an array of tikets(provided) and call ```->create()```.

Ticket types available: AirplaneTicket, BusTicket, CustomTicket.

For array output, call ```->getTickets()```.

For a human-readable list of instructions, call ```->getInstructions()```.

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use IM\ItineraryMaker;
use IM\Models\BusTicket;
use IM\Models\CustomTicket;

$tickets = [
    new BusTicket(
        '848484',
        new DateTime('2020-10-25 10:10:00'),
        new DateTime('2020-10-26 13:10:00'),
        'Southampton',
        'Newcastle',
        '112'
    ),
    new CustomTicket(
        '848484',
        new DateTime('2020-10-25 14:00:00'),
        new DateTime('2020-10-25 15:30:00'),
        '18-32 South Crees',
        'New Rd, Bolton Colliery NE35 9DR, United Kingdom',
        'taxi'
    ),
];

$im = (new ItineraryMaker($tickets))->create();
$output = $im->getTickets();
$instructions = $im->getInstructions();

```


