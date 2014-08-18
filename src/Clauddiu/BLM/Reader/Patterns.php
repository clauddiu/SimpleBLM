<?php namespace Clauddiu\BLM\Reader;

/**
 * Class Patterns
 *
 * @package Clauddiu\BLM\Reader
 */
final class Patterns {
    /**
     * BLM Data Sections
     *
     * @var array
     */
    protected $patterns = array(
        '#HEADER#(.+?)#'     => 'Header Section',
        '#DEFINITION#(.+?)#' => 'Definition Section',
        '#DATA#(.+?)#END#'   => 'Data Section',
    );

    /**
     * Header properties
     *
     * @var array
     */
    protected $header_properties = array(
        '([^/]*)EOF : \'(.+?)\'([^/]*)$'    => 'EOF',
        '([^/]*)EOR : \'(.+?)\'([^/]*)$'    => 'EOR',
        '([^/]*)Version :(.+)[^/]+$'        => 'VERSION',
        '([^/]*)Property Count :(.+)[^/]+$' => 'PROPERTY_COUNT',
        '([^/]*)Generated Date :(.+)[^/]+$' => 'GENERATED_DATE',
    );

    /**
     * @return array
     */
    public function getHeaderProperties()
    {
        return $this->header_properties;
    }

    /**
     * @return array
     */
    public function getPatterns()
    {
        return $this->patterns;
    }

}
