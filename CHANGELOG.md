Wearesho Message Delivery
=========================

2.0 under development
---------------------

- Remove `ContainsSenderName` interface, `MessageWithSender` implementation and `SenderNameTrait`.
Sender name configuration now can be done through message options.
- Remove `CheckBalance` interface, now method `balance` must be provided by `ServiceInterface` implementation.
- Add `name()` method to `ServiceInterface`
- Remove all `Wearesho\Delivery\Message\*` classes:
`Batch`, `BatchInterface`, `Recipient`, `RecipientTrait`, `Text`, `TextTrait`.
- 