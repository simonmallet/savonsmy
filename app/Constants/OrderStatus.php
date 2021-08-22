<?php

namespace App\Constants;

interface OrderStatus
{
    const NOT_TREATED = 'not_treated';
    const IN_PROGRESS = 'in_progress';
    const CANCELLED = 'cancelled';
    const COMPLETED = 'completed';

    const STATUSES = [self::NOT_TREATED, self::IN_PROGRESS, self::CANCELLED, self::COMPLETED];

    const TRANSITIONS = [
        self::NOT_TREATED => [self::IN_PROGRESS, self::CANCELLED],
        self::IN_PROGRESS => [self::COMPLETED, self::CANCELLED, self::NOT_TREATED],
        self::CANCELLED => [self::NOT_TREATED],
    ];
}
