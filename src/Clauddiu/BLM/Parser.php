<?php namespace Clauddiu\BLM;

use Clauddiu\BLM\Reader\Read;
use Clauddiu\BLM\Validators\Validator;

/**
 * Class Reader
 *
 * @package Clauddiu\BLM
 *
 * @example
 * $parser = new Parser();
 * $parsedData = $parser->load( $data )->parse();
 */
class Parser {

    /**
     * @var \Clauddiu\BLM\Validators\Validator
     */
    private $validateData;

    /**
     * @var \Clauddiu\BLM\Reader\Read
     */
    private $reader;

    /**
     * @var string
     */
    private $data;

    function __construct()
    {
        $this->validateData = new Validator();
        $this->reader       = new Read();
    }


    /**
     * Load blm data or blm file.
     *
     * @param string $data File path or blm data
     *
     * @return $this
     */
    public function load( $data )
    {
        # validate & assign data
        $this->data = $this->validateData->validate( $data );

        return $this;
    }


    /**
     * Parse data
     *
     * @return array
     */
    public function parse()
    {
        return $this->reader->build( $this->data );
    }
}
