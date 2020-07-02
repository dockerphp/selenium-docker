<?php
namespace Bigit\SeleniumMachine\Tests;

use Bigit\SeleniumMachine\Machine;
use Bigit\SeleniumMachine\SeleniumDocker;
use Bigit\SeleniumMachine\SeleniumHost;
use PHPUnit\Framework\TestCase;
use Spatie\Docker\DockerContainer;
use Spatie\Docker\DockerContainerInstance;

class MachineTest extends TestCase
{
    private SeleniumHost $server;
    private SeleniumDocker $docker;

    public function setUp(): void
    {
        parent::setUp();

        $this->server = new SeleniumHost();
        $this->docker = new SeleniumDocker();
    }

    /** @test */
    public function it_create_docker_container()
    {
        $container = $this->docker->create();
        $this->assertInstanceOf(DockerContainer::class, $container);
    }

    /** @test */
    public function it_create_selenium_docker_with_environments()
    {
        $env = [
            'NODE_MAX_SESSIONS' => 5,
            'NODE_MAX_INSTANCES' => 5
        ];

        $docker = new SeleniumDocker($env);
        $command = $docker->create()->getStartCommand();

        $this->assertEquals("docker run -p 4444:4444 -p 5900:5900 -e NODE_MAX_SESSIONS=5 -e NODE_MAX_INSTANCES=5 -v /dev/shm:/dev/shm --name selenium-docker -d --rm selenium/standalone-chrome-debug:latest", $command);
    }

    /** @test */
    public function it_create_selenium_instance()
    {
        $machine = new Machine();
        $instance = $machine->start($this->server, $this->docker);

        $this->assertInstanceOf(DockerContainerInstance::class, $instance);

        $machine->stop($this->docker, $instance->getDockerIdentifier());

        $this->doesNotPerformAssertions();
    }

}
