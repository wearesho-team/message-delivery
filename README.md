# Message Delivery
[![Latest Stable Version](https://poser.pugx.org/wearesho-team/message-delivery/v/stable.png)](https://packagist.org/packages/wearesho-team/message-delivery)
[![Total Downloads](https://poser.pugx.org/wearesho-team/message-delivery/downloads.png)](https://packagist.org/packages/wearesho-team/message-delivery)
[![PHP Composer](https://github.com/wearesho-team/message-delivery/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/wearesho-team/message-delivery/actions/workflows/php.yml)
[![codecov](https://codecov.io/gh/wearesho-team/message-delivery/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/message-delivery)

This repository includes standard interfaces and implementations
for simple message sending.

Compatibility: tested on PHP 8.4, PHP 8.5

## Installation
```bash
composer require wearesho-team/message-delivery:^2.4
```

## Contents

### Interfaces
- [ServiceInterface](./src/ServiceInterface.php) - message delivery service: `name()`, `balance()` and `send()`.
- [Batch\ServiceInterface](./src/Batch/ServiceInterface.php) - extends
[ServiceInterface](./src/ServiceInterface.php) with `batch()` for sending several messages.
- [MessageInterface](./src/MessageInterface.php) - message entity that includes
`recipient`, `text` and `options` fields. Known option keys are listed in [Options](./src/Options.php)
(sender name, channel, TTL).
- [ResultInterface](./src/ResultInterface.php) - result of sending a message: message id, message,
[status](./src/Result/Status.php) and reason.
- [BalanceInterface](./src/BalanceInterface.php) - service balance with `amount` and `currency`.
- [History\RepositoryInterface](./src/History/RepositoryInterface.php) - stores the history of sent messages
as [History\ItemInterface](./src/History/ItemInterface.php) entries.
- [Exception](./src/Exception.php) - exception thrown by
[ServiceInterface](./src/ServiceInterface.php) implementations if a message can not be sent.

### Implementations
- [Message](./src/Message.php), [Result](./src/Result.php), [Balance](./src/Balance.php)
(with [BalanceTrait](./src/BalanceTrait.php)) and [History\Item](./src/History/Item.php) - entities.
- [Batch\Service](./src/Batch/Service.php) - wraps any [ServiceInterface](./src/ServiceInterface.php)
and sends batches message by message (see also [Batch\ServiceTrait](./src/Batch/ServiceTrait.php)).
- [History\Service](./src/History/Service.php) - decorates a batch service and stores every result
in a [History\RepositoryInterface](./src/History/RepositoryInterface.php).
- [History\MemoryRepository](./src/History/MemoryRepository.php) - stores the history in memory.
Created for test purposes.
- [StubService](./src/StubService.php) - simple [Batch\ServiceInterface](./src/Batch/ServiceInterface.php)
implementation that sends nothing and returns a `Delivered` result for every message. Created for test purposes.
- [Test\History\RepositoryTest](./src/Test/History/RepositoryTest.php) - abstract PHPUnit test case
for [History\RepositoryInterface](./src/History/RepositoryInterface.php) implementations.

### Example

```php
<?php

require_once './vendor/autoload.php';

use Wearesho\Delivery;

$service = new Delivery\StubService();
$message = new Delivery\Message(
    text: 'hello',
    recipient: 'world'
);

$result = $service->send($message);
```

## Integrations
- [wearesho-team/yii2-message-delivery](https://github.com/wearesho-team/yii2-message-delivery) - Delivery\RepositoryInterface implementation,
Delivery\ServiceInterface implementation using async queue
- [wearesho-team/alphasms-message-delivery](https://github.com/wearesho-team/alphasms-message-delivery) - [AlphaSMS](https://alphasms.ua) integration
- [wearesho-team/telegram-message-delivery](https://github.com/wearesho-team/telegram-message-delivery) - Telegram bot integration implemented in
[irazasyed/telegram-bot-sdk](https://github.com/irazasyed/telegram-bot-sdk)

## Authors
- [Alexander <horat1us> Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE) 
