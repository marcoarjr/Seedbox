<?php
class Server
{
/*	implements the servers properties and methods
 * on create receives the server name
 * the unit test verify if the name is empty, wich is not alloewd
 * the instanced object initial status is 'stop'
 * 
 * to do: add more controls over the servers, like change name, address, services, etc
 * 
*/
	private $id;
	private $name;
	private $running_status;

    public function __construct($server_name,$server_running_status = 'STOP')
    {
        $this->ensureIsValidServerName($server_name);

        $this->name = $server_name;
        $this->running_status = $server_running_status;
    }
    private function ensureIsValidServerName($server_name)
    {
        if (trim($server_name) == '') {
            throw new InvalidArgumentException(
                printf('Invalid Serever Name')
            );
        }
    }

    public function getServerName()
    {
		//returns the server name
        return $this->name;
    }

    public function getServerStatus()
    {
		//returns the server running statur
        return $this->running_status;
    }
    
    public function	startServer()
    {
		// changes the server's running status to start
		$this->running_status = 'START';
		return 'Start';
	}
	
    public function	stopServer()
    {
		// changes the server's running status to stop
		$this->running_status = 'STOP';
		return 'Stop';
	}
}
?>
