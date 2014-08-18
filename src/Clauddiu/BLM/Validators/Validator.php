<?php namespace Clauddiu\BLM\Validators;

use Clauddiu\BLM\Exceptions\FileMissingBLMException;

/**
 * Class Validator
 *
 * @package Clauddiu\BLM\Validators
 */
class Validator {

    /**
     * @var DataValidator
     */
    private $dataValidator;

    function __construct()
    {
        $this->dataValidator = new DataValidator();
    }

    /**
     * Validate data provided
     *
     * @param mixed $data
     *
     * @throws \Clauddiu\BLM\Exceptions\FileMissingBLMException
     *
     * @return bool
     */
    public function validate( $data )
    {
        $file = explode( '.', $data );

        # check if is a file path if so we should load it
        if ( strtolower( end( $file ) ) == 'blm' )
        {
            if (file_exists($data))
            {
                # get file data
                $fileData = file_get_contents($data, LOCK_EX);

                # looks like we have a file but we will also check the content
                return $this->dataValidator->validate( $fileData );
            }

            throw new FileMissingBLMException( 'Missing BLM File [' . $data . ']' );
        }

        # validate content
        return $this->dataValidator->validate( $data );
    }

}
