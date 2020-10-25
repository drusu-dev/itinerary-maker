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
$itineraryMaker = (new ItineraryMaker($tickets))->create();

$tickets = $itineraryMaker->getTickets();

$instructions = $itineraryMaker->getInstructions();
```


