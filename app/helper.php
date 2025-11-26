<?php

use Illuminate\Support\Str;

function uuidGenerator()
{
    return Str::uuid()->toString();
}
