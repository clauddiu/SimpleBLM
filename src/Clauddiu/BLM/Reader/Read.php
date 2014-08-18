<?php namespace Clauddiu\BLM\Reader;

/**
 * Class Parser
 *
 * @package Clauddiu\BLM\Reader
 */
final class Read {

    private $parserProperty;

    private $patterns;

    function __construct()
    {
        $this->parserProperty = new Property();
        $this->patterns       = new Patterns();
    }

    /**
     * Build data
     *
     * @param $data
     *
     * @return array
     *
     * @throws \Clauddiu\BLM\Exceptions\InvalidBLMException
     */
    public function build( $data )
    {
        #header property
        list( $eof, $eor, $version, $count, $date ) = $this->parserProperty->getHeaderProperty( $data );

        # get definitions
        $definitions = $this->parserProperty->getDefinitionProperty( $data, $eof );

        # build rows
        $data = $this->rows( $data, $eof, $eor, $definitions );

        # build data
        return array(
            'version' => $version,
            'count'   => $count,
            'date'    => $date,
            'data'    => $data
        );
    }

    /**
     * Build Rows
     *
     * @param $data
     * @param $eof
     * @param $eor
     * @param $definitions
     *
     * @return array
     */
    private function rows( $data, $eof, $eor, $definitions )
    {
        # get header pattern
        $patterns = array_keys( $this->patterns->getPatterns() );
        $pattern  = $patterns[ 2 ];

        if ( preg_match( '/' . $pattern . '/sm', $data, $match ) )
        {
            return $this->getRows( $data, $eof, $eor, $definitions, $match[ 1 ] );
        }
    }

    /**
     * Get Rows
     *
     * @param array  $data
     * @param string $eof
     * @param string $eor
     * @param array  $definitions
     * @param        $match
     *
     * @return array
     */
    private function getRows( $data, $eof, $eor, $definitions, $match )
    {
        $data = array();

        foreach ( array_map( 'trim', explode( $eor, $match ) ) as $index => $row )
        {
            $data = $this->getDefinitions( $data, $eof, $definitions, $row, $index );
        }

        return $data;
    }

    /**
     * Build definitions
     *
     * @param array  $data
     * @param string $eof
     * @param array  $definitions
     * @param string $row
     * @param int    $index
     *
     * @return array
     */
    private function getDefinitions( $data, $eof, $definitions, $row, $index )
    {
        $fields = array_map( 'trim', explode( $eof, $row ) );

        if ( count( $fields ) > 1 )
        {
            $data[ $index ] = array();

            foreach ( $fields as $k => $field )
            {
                if ( isset( $definitions[ $k ] ) )
                {
                    $data[ $index ][ $definitions[ $k ] ] = $field;
                }
            }

            return $data;
        }

        return $data;
    }
}
