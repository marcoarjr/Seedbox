<?php
class Server
{
	private $id;
	private $name;
	private $running_status;
	
    public function __construct($server_name)
    {
        $this->ensureIsValidServerName($server_name);

        $this->name = $server_name;
        $this->running_status = 'Stop';
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
        return $this->name;
    }

    public function getServerStatus()
    {
        return $this->running_status;
    }
    
    public function	startServer()
    {
		$this->running_status = 'Start';
	}
	
    public function	stopServer()
    {
		$this->running_status = 'Stop';
	}
}
?>
