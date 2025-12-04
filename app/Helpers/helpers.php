<?php

use App\Models\Setting;

if (!function_exists('format_date')) {
    /**
     * Format a date using the application's configured date format.
     *
     * @param \Carbon\Carbon|string|null $date
     * @param string|null $format Override format (optional)
     * @return string
     */
    function format_date($date, $format = null)
    {
        if (!$date) {
            return '';
        }

        // Convert to Carbon if string
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        // Get format from settings if not provided
        if (!$format) {
            try {
                $format = Setting::get('date_format', 'd/m/Y');
            } catch (\Exception $e) {
                $format = 'd/m/Y';
            }
        }

        return $date->format($format);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format a datetime using the application's configured date format + time.
     *
     * @param \Carbon\Carbon|string|null $datetime
     * @return string
     */
    function format_datetime($datetime)
    {
        if (!$datetime) {
            return '';
        }

        // Convert to Carbon if string
        if (is_string($datetime)) {
            $datetime = \Carbon\Carbon::parse($datetime);
        }

        try {
            $dateFormat = Setting::get('date_format', 'd/m/Y');
        } catch (\Exception $e) {
            $dateFormat = 'd/m/Y';
        }

        return $datetime->format($dateFormat . ' H:i');
    }
}
