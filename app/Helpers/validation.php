<?php

declare(strict_types=1);

/**
 * Data Validation and Safety Utilities.
 *
 * A collection of functions for safely handling data access, validation,
 * and sanitization. These utilities provide consistent ways to:
 * - Safely access array values without warnings
 * - Validate and sanitize field values
 * - Handle nested array structures
 * - Debug data with formatted output
 *
 * Functions:
 * - safe_field(): Validate and optionally sanitize any field value
 * - output(): Debug-friendly data output formatting
 */

if ( ! defined('ABSPATH')) {
    exit(); // Exit if accessed directly
}

/**
 * Safely validate and access field values.
 *
 * @param  mixed  $field  Field to check (string, array, or any scalar value)
 * @param  string|array|null  $key  Optional array key or keys for nested access
 * @param  mixed  $default  Default value if key doesn't exist
 *
 * @return mixed Field value or default value if invalid
 */
function safe_field($field, $key = null, $default = '')
{
    // Handle array access if key is provided
    if ($key !== null) {
        if ( ! is_array($field)) {
            return $default;
        }

        // Handle nested key array (e.g., ['parent', 'child'])
        if (is_array($key)) {
            $current = $field;

            foreach ($key as $k) {
                if ( ! is_array($current) || ! isset($current[$k])) {
                    return $default;
                }

                $current = $current[$k];
            }

            $field = $current;
        } else {
            // Simple key access
            $field = isset($field[$key]) ? $field[$key] : $default;
        }
    }

    // Handle null or non-existent array keys
    if ($field === null) {
        return $default;
    }

    // Handle array input
    if (is_array($field)) {
        // For arrays, only filter out completely empty arrays
        // but preserve arrays that have any non-empty values
        $filtered = array_filter($field, function ($value) {
            if (is_array($value)) {
                // If it's a nested array, check if it has any non-empty values
                return ! empty(array_filter($value, function ($v) {
                    return ! empty($v) || $v === 0 || $v === '0';
                }));
            }

            // For scalar values, keep non-empty values
            return ! empty($value) || $value === 0 || $value === '0';
        });

        return $filtered;
    }

    // Convert numeric 1/0 to boolean for boolean contexts
    if ($field === '1' || $field === 1) {
        return true;
    }

    if ($field === '0' || $field === 0) {
        return false;
    }

    // Handle other scalar values (string, int, float, bool)
    if ( ! empty($field) || $field === false) {
        return $field;
    }

    return $default;
}

/**
 * Readable output data dumps.
 *
 * @param  array  $data  Array of data to output.
 * @param  bool  $return_output  Whether to return the markup instead of outputting it.
 *
 * @return void|string The data output in pre tag.
 */
function output($data, bool $return_output = false)
{
    $output =
        '<pre style="background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #333;
            font-family: Menlo, Consolas, Monaco, Liberation Mono, Lucida Console, monospace;
            font-size: 14px;
            line-height: 1.5;
            margin: 20px;
            overflow-x: auto;
            padding: 10px;
            position: relative;
            white-space: pre-wrap;
            z-index: 2;">' . print_r($data, true) . '</pre>';

    if ($return_output) {
        return $output;
    } else {
        echo $output;
    }
}
