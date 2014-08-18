<?php namespace Clauddiu\BLM\Validators;

/**
 * Interface ValidateInterface

 * @package Clauddiu\BLM\Validators
 */
interface ValidateInterface {

    /**
     * Determine if the data provided is valid
     *
     * @param mixed|string $data
     *
     * @return bool
     */
    public function validate( $data );
}
