<?php

namespace App\Services;

use Illuminate\Support\Str;

class QrTokenService
{
    public static function generar(): string
    {
        return (string) Str::uuid();
    }
}