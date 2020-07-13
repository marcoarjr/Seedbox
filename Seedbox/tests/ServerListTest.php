<?php

use PHPUnit\Framework\TestCase;

class ServerT { 
	public function dummyFunction(){return true;} 
} 
  
class ServerListT { 
	public function dummyFunction(){return true;} 
} 
	
final class ServerListTest extends TestCase
{
	public function testNegativeTestcaseForAssertContainsOnlyInstancesOf() 
	{ 
	  
		// Assert function to test whether testArray contains 
		// only instance of Foo or not 
		$this->assertContainsOnlyInstancesOf( 
			Server::class, 
			[new ServerT, new ServerListT, new ServerT],  
			"testArray doesn't contains only instance of Server"
		); 
	} 
}
?>
