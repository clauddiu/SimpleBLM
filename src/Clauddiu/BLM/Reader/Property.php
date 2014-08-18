<?php namespace Clauddiu\BLM\Reader;

use Clauddiu\BLM\Exceptions\InvalidBLMException;

/**
 * Class ParserProperty
 *
 * @package Clauddiu\BLM\Reader
 */
final class Property {

    protected $header;
    protected $definition;
    protected $data;

    private $patterns;

    function __construct()
    {
        $this->patterns = new Patterns();
    }

    /**
     * Get header property
     *
     * @param string $data
     *
     * @return array
     *
     * @throws \Clauddiu\BLM\Exceptions\InvalidBLMException
     */
    public function getHeaderProperty( $data )
    {
        # get header pattern
        $patterns = array_keys( $this->patterns->getPatterns() );
        $pattern  = $patterns[ 0 ];

        if ( preg_match( '/' . $pattern . '/sm', $data, $match ) )
        {
            return $this->getPropertyValue( $match );
        }

        throw new InvalidBLMException( 'Invalid Header Section' );
    }

    /**
     * @param $data
     * @param $eof
     *
     * @return array
     *
     * @throws \Clauddiu\BLM\Exceptions\InvalidBLMException
     */
    public function getDefinitionProperty( $data, $eof )
    {
        # get definition pattern
        $patterns = array_keys( $this->patterns->getPatterns() );
        $pattern  = $patterns[ 1 ];

        if ( preg_match( '/' . $pattern . '/sm', $data, $match ) )
        {
            return $this->getDefinitions( $eof, $match );
        }

        throw new InvalidBLMException( 'Invalid Definition Section' );
    }

    /**
     * Get property value
     *
     * @param array $match
     * @param bool  $assoc
     *
     * @return array
     */
    private function getPropertyValue( $match, $assoc = false )
    {
        $property = array();

        foreach ( $this->patterns->getHeaderProperties() as $regex => $property_name )
        {
            $property[ $property_name ] = trim( preg_replace( "#" . $regex . "#", "$2", $match[ 1 ] ) );
        }

        return ( $assoc ) ? $property : array_values( $property );
    }

    /**
     * Get definitions
     *
     * @param $eof
     * @param $match
     *
     * @return array
     */
    private function getDefinitions( $eof, $match )
    {
        $fields = array_map( 'trim', explode( $eof, $match[ 1 ] ) );

        array_pop( $fields );

        return $fields;
    }
}
