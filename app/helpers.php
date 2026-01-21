<?php

if (! function_exists('country_flag')) {
    function country_flag(string $iso): string
    {
        return collect(str_split(strtoupper($iso)))
            ->map(fn ($char) => mb_chr(127397 + ord($char)))
            ->join('');
    }
}
