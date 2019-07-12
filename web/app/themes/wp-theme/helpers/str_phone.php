<?php
/**
 * Return a clean phone number.
 *
 * Removes everything, but numbers, eg:
 * `str_phone('020 - 320 24 68')` becomes '0203202468'
 * `str_phone('020 320 24 68', '+31')` becomes '+31203202468'
 *
 * @param  string $phone  The filthy phonenumber. We like 'm real dirty!
 * @param  string $prefix The country code, eg. '+31' of whatever floats your boat.
 *
 * @return string         The clean phonenumber. With or without prefix.
 */

function str_phone(string $phone, string $prefix = '')
{
    // Strip everything but numbers
    $phone = preg_replace('/\D+/', '', $phone);

    // Remove all leading zero's if prefix is used
    if ('' !== $prefix) {
        $phone = $prefix . ltrim($phone, '0');
    }

    return (string) $phone;
}
