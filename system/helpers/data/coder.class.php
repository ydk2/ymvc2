<?php
/**
 *
 */
abstract class coder {

    function __construct() {
    }

    static function bin2bstr($input)
    // Convert a binary expression (e.g., "100111") into a binary-string
    {
        if (!is_string($input))
            return null;
        // Sanity check

        // Pack into a string
        return pack('H*', base64_encode($input));
    }

   static function bstr2bin($input)
    // Binary representation of a binary-string
    {
        if (!is_string($input))
            return null;
        // Sanity check

        // Unpack as a hexadecimal string
        $value = unpack('H*', $input);

        // Output binary representation
        return base64_decode($value[1]);
    }

}
?>