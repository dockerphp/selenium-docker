<?php
/**
 * Class SeleniumDocker;
 * SeleniumDocker.php
 * created on: 01/07/2020 - 18:55
 */

namespace DockerPhp\SeleniumMachine;


use Spatie\Docker\DockerContainer;
use Spatie\Docker\DockerContainerInstance;

class SeleniumDocker
{
    protected string $dockerImage = 'selenium/standalone-chrome-debug:latest';
    
    public string $name;
    protected int $selenium_port;
    protected int $vnc_port;
    protected string $host_volume;
    protected array $environments;

    public function __construct($environments = [], $name = "selenium-docker", $selenium_port = 4444, $vnc_port = 5900, $host_volume = "/dev/shm")
    {
        $this->name = $name;
        $this->selenium_port = $selenium_port;
        $this->vnc_port = $vnc_port;
        $this->host_volume = $host_volume;
        $this->environments = $environments;
    }
    
    public function create() : DockerContainer
    {
        $docker = DockerContainer::create($this->dockerImage)
            ->name($this->name)
            ->mapPort($this->selenium_port, 4444)
            ->mapPort($this->vnc_port, 5900)
            ->setVolume($this->host_volume, '/dev/shm');

        foreach($this->environments as $environment => $value)
        {
            $docker->setEnvironmentVariable($environment, $value);
        }

        return $docker;
    }

}
