<?php

namespace Flowcode\DashboardBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Created by PhpStorm.
 * User: juanma
 * Date: 5/28/16
 * Time: 12:11 PM
 */
class CollectJobsEvent extends Event
{
    const NAME = 'amulen.event.collect_jobs';

    protected $registeredJobs;

    public function __construct($registeredJobs)
    {
        $this->registeredJobs = $registeredJobs;
    }

    /**
     * @param $job
     */
    public function pushJob($job)
    {
        array_push($this->registeredJobs, $job);
    }

    /**
     * @return mixed
     */
    public function getRegisteredJobs()
    {
        return $this->registeredJobs;
    }

    /**
     * @param mixed $registeredJobs
     */
    public function setRegisteredJobs($registeredJobs)
    {
        $this->registeredJobs = $registeredJobs;
    }


}