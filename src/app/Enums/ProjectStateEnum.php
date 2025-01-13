<?php

namespace App\Enums;

enum ProjectStateEnum: string
{
    case DRAFT = 'draft';
    case IN_PROGRESS = 'in_progress';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => __('Draft'),
            self::IN_PROGRESS => __('In progress'),
            self::FINISHED => __('Finished'),
            self::CANCELED => __('Canceled'),
        };
    }
}
