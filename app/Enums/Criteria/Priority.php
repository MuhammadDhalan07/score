<?php

namespace App\Enums\Criteria;

use Filament\Support\Contracts\HasLabel;

enum Priority: int implements HasLabel
{
    case Satu = 1;
    case Dua = 2;
    case Tiga = 3;
    case Empat = 4;
    case Lima = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::Satu => 1,
            self::Dua => 2,
            self::Tiga => 3,
            self::Empat => 4,
            self::Lima => 5,
        };
    }
}
