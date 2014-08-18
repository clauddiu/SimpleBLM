<?php namespace Clauddiu\BLM\Validators;

use Clauddiu\BLM\Exceptions\InvalidBLMException;
use Clauddiu\BLM\Reader\Patterns;

/**
 * Class DataValidator
 *
 * @package Clauddiu\BLM\Validators
 */
class DataValidator implements ValidateInterface {

    /**
     * @var \Clauddiu\BLM\Reader\Patterns;
     */
    protected $patterns;

    function __construct()
    {
        $this->patterns = new Patterns();
    }

    /**
     * Validate data
     *
     * @param mixed|string $data
     *
     * @return bool|void
     */
    public function validate( $data )
    {
        return $this->check( $data );
    }


    private function check( $data )
    {
        # loop trough our patterns
        foreach ( $this->patterns->getPatterns() as $section => $section_name )
        {
            if ( !preg_match( '/' . $section . '/sm', $data, $match ) )
            {
                throw new InvalidBLMException( $section_name . ' it\'s missing!' );
            }
        }

        return $data;
    }
}
