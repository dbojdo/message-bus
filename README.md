# PHP Message Bus

The library provides an abstraction to publish / consume messages to / from message bus.

## Installation

```bash
composer require webit/message-bus ^1.0.0
```

## Concepts introduction

### Message

***Message*** is just simple container to be *published* by ***Publisher*** and *consumed* by ***Consumer***.

```php
$message = new Message('message-type', json_encode(['some' => 'data to be sent']));
```

Message **type** is required to recognise what sort of message is sent and helps to understand how it should be handled.
Message **content** is a message itself. It can be ***any string*** (not necessarily json).

### Publisher and Consumer

***Publisher*** publishes a message (using underlying infrastructure) but ***Consumer*** awaiting the ***Message*** to process it.

Infrastructure is to be provided by a separate package.
It should **provide** "webit/message-bus-infrastructure:^1.0.0" Composer Virtual Package.

## Tests

```bash
./vendor/bin/phpunit
```
