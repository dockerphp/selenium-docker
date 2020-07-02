<?php
/**
 * Class SeleniumHost;
 * SeleniumHost.php
 * created on: 01/07/2020 - 19:55
 */

namespace DockerPhp\SeleniumMachine;


class SeleniumHost
{
    public string $host;
    public string $user;
    public int $ssh_port;
    public string $privateKey;

    public function __construct($host = 'localhost', $user = 'vagrant', $ssh_port = 22, $privateKey = "/home/vagrant/.ssh/id_rsa")
    {
        $this->host = $host;
        $this->user = $user;
        $this->ssh_port = $ssh_port;
        $this->privateKey = $privateKey;
    }
}
