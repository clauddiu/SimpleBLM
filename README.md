#SimpleBLM Reader
Rightmove BLM parser for PHP

##Requirements
* PHP 5.4+

##Usage
```php
<?php
use Clauddiu\BLM\Parser;
$parser  = new Parser();
$data    = file_get_contents( 'sample.blm' );
$parsedData = $reader->load( $data )->parse();
var_dump($parsedData);
```
