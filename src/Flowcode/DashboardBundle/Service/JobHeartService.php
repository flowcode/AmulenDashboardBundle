<?php

namespace Flowcode\DashboardBundle\Service;

use Flowcode\DashboardBundle\Event\CollectJobsEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * User: juanma
 * Date: 5/28/16
 * Time: 6:03 PM
 */
class JobHeartService
{

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @var string
     */
    private $environment;

    /**
     * JobHeartService constructor.
     * @param EventDispatcherInterface $eventDispatcher
     * @param string $rootDir
     * @param string $environment
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, $rootDir, $environment)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->rootDir = $rootDir;
        $this->environment = $environment;
    }


    public function heartBeat()
    {
        $registeredJobs = [];
        $collectJobsEvent = new CollectJobsEvent($registeredJobs);

        $this->eventDispatcher->dispatch(CollectJobsEvent::NAME, $collectJobsEvent);

        $this->runJobs($collectJobsEvent->getRegisteredJobs());

    }

    /**
     * @param array $jobList
     */
    public function runJobs($jobList = [])
    {
        foreach ($jobList as $job) {
            if (isset($job['command'])) {
                $this->runJob($job['command']);
            }
        }
    }

    /**
     * @param $jobname
     */
    public function runJob($jobname)
    {

        $commandCall = "php " . $this->rootDir . "/console ";
        $commandCall .= $jobname;
        $commandCall .= " --env=" . $this->environment . " > /dev/null &";

        exec($commandCall);

    }


}