<?php

use Clauddiu\BLM\Parser;

class ParserTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \Clauddiu\BLM\Parser
     */
    protected $parser;

    public function setUp()
    {
        $this->parser = new Parser();
    }

    public function testCanContructReader()
    {
        $reader = new Parser();
        $this->assertTrue( get_class( $reader ) == 'Clauddiu\BLM\Parser' );
    }

    public function testParserCanLoadFileOrString()
    {
        # load file
        $blmData = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'data.blm';

        $data = $this->parser->load($blmData)->parse();

        $this->assertArrayHasKey('data', $data);


        # from string
        $getData = file_get_contents($blmData);

        $data = $this->parser->load($getData)->parse();

        $this->assertArrayHasKey('data', $data);
    }

    public function testParseReturnFormattedArray()
    {
        # load from file
        $blmData = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'data.blm';

        $data = $this->parser->load($blmData)->parse();

        $this->assertArrayHasKey('version', $data);
        $this->assertArrayHasKey('count', $data);
        $this->assertArrayHasKey('date', $data);
        $this->assertArrayHasKey('data', $data);
        $this->assertTrue($data['count'] == count($data['data']));
    }


    public function testInvalidBLMExceptionBadHeader()
    {
        $blmData = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'bad-header.blm';

        try
        {
            $this->parser->load($blmData)->parse();
        }
        catch( \Clauddiu\BLM\Exceptions\InvalidBLMException $e)
        {
            $this->assertEquals('Header Section it\'s missing!', $e->getMessage());
        }
    }

    public function testInvalidBLMExceptionBadDefinition()
    {
        $blmData = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'bad-definition.blm';

        try
        {
            $this->parser->load($blmData)->parse();
        }
        catch( \Clauddiu\BLM\Exceptions\InvalidBLMException $e)
        {
            $this->assertEquals('Definition Section it\'s missing!', $e->getMessage());
        }
    }

    public function testInvalidBLMExceptionBadData()
    {
        $blmData = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'bad-data.blm';

        try
        {
            $this->parser->load($blmData)->parse();
        }
        catch( \Clauddiu\BLM\Exceptions\InvalidBLMException $e)
        {
            $this->assertEquals('Data Section it\'s missing!', $e->getMessage());
        }
    }

    public function testFileMissingException()
    {
        $blmData = 'missing-file.blm';

        try
        {
            $this->parser->load($blmData)->parse();
        }
        catch( \Clauddiu\BLM\Exceptions\FileMissingBLMException $e)
        {
            $this->assertEquals('Missing BLM File [' . $blmData . ']' , $e->getMessage());
        }
    }

}
