<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Result;

enum Status: string
{
    /** The message has been accepted for processing and will be sent. */
    case Queued = 'Queued';
    /** Message sent to the mobile network, but not yet processed by the operator */
    case Accepted = "Accepted";
    /** Message sent and awaiting delivery */
    case Sent = "Sent";
    /** Message delivered to recipient */
    case Delivered = "Delivered";
    /** The message has been read by the recipient */
    case Read = "Read";
    /** The message for which it should have been delivered has expired */
    case Expired = "Expired";
    case Undelivered = "Undelivered";
    case Rejected = "Rejected";
    case Unknown = "Unknown";
    case Failed = "Failed";
    case Cancelled = "Cancelled";
    case Error = "Error";
}
