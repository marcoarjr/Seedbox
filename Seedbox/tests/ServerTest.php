<?php

use PHPUnit\Framework\TestCase;

final class ServerTest extends TestCase
{
    public function testNameCannotBeEmpty()
    {
		$test = 'abc';
		$this->assertInternalType('string', $test, "Got a " . gettype($test) . " instead of a string.");
		//$this->assertIsString($server_name);
    }


}
?>
