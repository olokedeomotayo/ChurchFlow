<?php

namespace App\Services;

use App\Models\Church;

class ChurchCodeGenerator
{
    public function generate(): string
    {
        do {
            $code = 'CF-' . strtoupper(
                substr(bin2hex(random_bytes(4)), 0, 6)
            );
        } while (Church::where('code', $code)->exists());

        return $code;
    }
}