<?php
/**
 * Class CouldNotStopContainer;
 * CouldNotStopContainer.php
 * created on: 02/07/2020 - 0:14
 */

namespace Bigit\SeleniumMachine\Exceptions;


use Bigit\SeleniumMachine\SeleniumDocker;
use Symfony\Component\Process\Process;

class CouldNotStopDockerContainer extends \Exception
{
    public static function processFailed(SeleniumDocker $docker, Process $process)
    {
        return new static("Could not stop {$docker->name}. Process output: {$process->getOutput()}");
    }
}
