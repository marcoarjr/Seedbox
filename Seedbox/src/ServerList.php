<?php

class ServerList
{
/* implements thhe serve inventory list
 * on create receives no paramenters and returns an empty list
 * 
*/
	public $server_inventory;
	
	private function unsetValue(array $array, $value, $strict = TRUE)
	{
		if(($key = array_search($value, $array, $strict)) !== false){
			unset($array[$key]);
		}
		return $array;
	}

	public function __construct()
    {
        $this->server_inventory = [];

    }
    
    public function getServerList()
    {
		// returns the servers name and status
        foreach ($this->server_inventory as $element){
			printf($element->getServerName().' - '); 
			printf($element->getServerStatus().'<br>'.PHP_EOL); 
		}
        return $this->server_inventory;
    }
    
    public function	serverAdd($server)
    {
		//add a server at th end of the list
		array_push($this->server_inventory, $server);
	}    

    public function	serverRemove($server_name)
    {
		// removes given server from the list
		$item = null;
		foreach($this->server_inventory as $struct) {
			if ($server_name == $struct->getServerName()) {
				$item = $struct;
				break;
			}
		}		
		if ($item != null) {
			$this->server_inventory = $this->unsetValue($this->server_inventory,$item);
			
		}
	}    

}
?>
