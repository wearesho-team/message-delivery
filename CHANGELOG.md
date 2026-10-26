Wearesho Message Delivery
=========================

2.4.0
-----

- Require PHP >= 8.4 (was ^8.1). Tested on PHP 8.4 and PHP 8.5.
- `Test\History\RepositoryTest` creates its message and history item doubles with `createStub()`,
so test cases extending it don't get "No expectations were configured for the mock object" notices on PHPUnit 12.5+.
- Maintenance: PHPUnit 13, PHP_CodeSniffer 4, GitHub Actions on PHP 8.4 and 8.5 with Clover coverage for Codecov.

2.0.0
-----

- Remove `ContainsSenderName` interface, `MessageWithSender` implementation and `SenderNameTrait`.
Sender name configuration now can be done through message options.
- Remove `CheckBalance` interface, now method `balance` must be provided by `ServiceInterface` implementation.
- Add `name()` method to `ServiceInterface`
- Remove all `Wearesho\Delivery\Message\*` classes:
`Batch`, `BatchInterface`, `Recipient`, `RecipientTrait`, `Text`, `TextTrait`.
