<?php
namespace DockerPhp\SeleniumMachine;

use DockerPhp\SeleniumMachine\Exceptions\CouldNotStopDockerContainer;
use Spatie\Docker\DockerContainerInstance;
use Spatie\Docker\Exceptions\CouldNotStartDockerContainer;
use Spatie\Ssh\Ssh;

class Machine
{
    public function start(SeleniumHost $server, SeleniumDocker $docker) : DockerContainerInstance
    {
        $container = $docker->create();

        $process = Ssh::create($server->user, $server->host, $server->ssh_port)
            ->usePrivateKey($server->privateKey)
            ->execute($container->getStartCommand());

        if (! $process->isSuccessful()) {
            throw CouldNotStartDockerContainer::processFailed($container, $process);
        }

        $dockerIdentifier = $process->getOutput();

        return new DockerContainerInstance(
            $container,
            $dockerIdentifier,
            $container->name,
        );
    }

    public function stop(SeleniumDocker $docker, $docker_id) : void
    {
        $container = $docker->create();

        $instance = new DockerContainerInstance($container, $docker_id, $docker->name);

        $process =  $instance->stop();

        if (!$process->isSuccessful()) {
            throw CouldNotStopDockerContainer::processFailed($docker, $process);
        }
    }
}
