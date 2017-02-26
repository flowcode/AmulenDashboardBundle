<?php

namespace Flowcode\DashboardBundle\Command;

use Sensio\Bundle\GeneratorBundle\Manipulator\KernelManipulator;
use Sensio\Bundle\GeneratorBundle\Manipulator\RoutingManipulator;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * User: juanma
 * Date: 5/28/16
 * Time: 10:47 AM
 */
class JobHeartCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('amulen:job:heart')
            ->setDescription('Job main runner');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $jobHeartService = $this->getContainer()->get('amulen.dashboard.service.job_heart');

        $output->write("pum..");

        $jobHeartService->heartBeat();

        $output->writeln("pum");
    }


}