# Message Delivery
This repository includes standard interfaces and implementations
for simple message sending.  
This interfaces created to be used by [Wearesho Team](https://wearesho.com/)

## Installation
```bash
composer require wearesho-team/message-delivery
```

## Contents

### Interfaces
- [Exception](./src/Exception.php) - exception that will be thrown by
[ServiceInterface](./src/ServiceInterface.php) if message can not be sent.
- [MessageInterface](./src/MessageInterface.php) - message entity that includes
`recipient` and `text` fields. Can be extended with additional fields.
- [RepositoryInterface](./src/RepositoryInterface.php) - messages repository.
Stores history of message sending. Can be used as dependency in
[ServiceInterface](./src/ServiceInterface.php) implementations.

### Implementations
- [MessageTrait](./src/MessageTrait.php) - traits with getters for
[MessageInterface](./src/MessageInterface.php) fields.
- [Message](./src/Message.php) - entity, that uses MessageTrait.
- [ServiceMock](./src/ServiceMock.php) - simple [ServiceInterface](./src/ServiceInterface.php)
implementation. Created for test purposes. 
- [MemoryRepository](./src/MemoryRepository.php) - simple [RepositoryInterface](./src/RepositoryInterface.php)
implementation that allows to store history in memory. Created for test purposes.

### Example

```php
<?php

require_once './vendor/autoload.php';

use Wearesho\Delivery;

$service = new Delivery\ServiceMock();
$message = new Delivery\Message(
    $text = 'hello',
    $recipient = 'world'
);

$service->send($message);
```

## Authors
- [Alexander <horat1us> Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE) 