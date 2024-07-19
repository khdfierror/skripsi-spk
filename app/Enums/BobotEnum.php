<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BobotEnum: string implements HasLabel
{
    case BOBOT_1 = '1';
    case BOBOT_2 = '2';
    case BOBOT_3 = '3';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BOBOT_1 => 'Bobot 1',
            self::BOBOT_2 => 'Bobot 2',
            self::BOBOT_3 => 'Bobot 3',
        };
    }
}
