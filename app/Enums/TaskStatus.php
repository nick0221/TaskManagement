<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TaskStatus extends Enum
{
    const IN_PROGRESS = 'In-progress';
    const TODO = 'To-do';
    const DONE = 'Done';


    public static function toSelectArray(): array
    {
        return [
            self::TODO => 'To-do',
            self::IN_PROGRESS => 'In-progress',
            self::DONE => 'Done',
        ];
    }

    /**
     * @param  string  $value
     * @return string
     */
    public static function description(string $value): string
    {
        return match ($value) {
            self::IN_PROGRESS => 'Task status is in progress',
            self::TODO => 'Tasks that need to be done',
            self::DONE => '',
            default => 'No status',
        };
    }

    /**
     * @param  string  $value
     * @return string
     */
    public function color(string $value): string
    {
        return match ($value) {
            self::IN_PROGRESS => 'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  ',
            self::TODO => 'bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ',
            self::DONE => 'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  ',
            default => 'bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  ',
        };
    }
}
