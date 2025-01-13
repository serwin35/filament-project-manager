<?php

namespace App\Enums;

enum TaskStateEnum: string
{
    case DRAFT = 'draft';
    case BACKLOG = 'backlog';
    case IN_PROGRESS = 'in_progress';
    case REVIEW = 'review';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => __('Draft'),
            self::BACKLOG => __('Backlog'),
            self::IN_PROGRESS => __('In progress'),
            self::REVIEW => __('Review'),
            self::FINISHED => __('Finished'),
            self::CANCELED => __('Canceled'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::BACKLOG => 'black',
            self::IN_PROGRESS => 'blue',
            self::REVIEW => 'yellow',
            self::FINISHED => 'green',
            self::CANCELED => 'red',
        };
    }

    public static function listState(): array
    {
        return [
            self::BACKLOG,
            self::IN_PROGRESS,
            self::REVIEW,
            self::FINISHED,
            self::CANCELED,
        ];
    }
}
