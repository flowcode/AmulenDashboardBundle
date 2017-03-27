<?php

namespace Flowcode\DashboardBundle\Command;

use Amulen\SettingsBundle\Model\SettingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Flowcode\DashboardBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of UpgradeCommand
 *
 * @author Juan Manuel Agüero <jaguero@flowcode.com.ar>
 */
abstract class AmulenCommand extends ContainerAwareCommand
{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var SettingRepository
     */
    protected $settings;


    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Init message.
        $initMsg = date("Y-m-d H:i:s") . " - " . $this->getDescription() . " started.";
        $this->getContainer()->get("logger")->info($initMsg);
        $output->writeln($initMsg);

        // Job init.
        $job = $this->getJob();
        $job->setStatus(Job::STATUS_DOING);
        $this->getEM()->flush();

        try {

            // Execute Task.
            $this->task($input, $output);

            $job->setStatus(Job::STATUS_DONE_OK);
            $this->getEM()->flush();


            // Finish message.
            $doneMsg = date("Y-m-d H:i:s") . " - " . $this->getDescription() . " finished.";
            $this->getContainer()->get("logger")->info($doneMsg);
            $output->writeln($doneMsg);

        } catch (\Exception $exception) {

            $job->setStatus(Job::STATUS_DONE_FAIL);
            $this->getEM()->flush();

        }


    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    abstract function task(InputInterface $input, OutputInterface $output);

    /**
     * @return Job
     */
    protected function getJob()
    {
        /** @var Job $job */
        $job = $this->getEM()->getRepository(Job::class)->findOneBy([
            'name' => $this->getName()
        ]);

        if (!$job) {
            $job = new Job();
            $job->setName($this->getName());
            $this->getEM()->persist($job);
            $this->getEM()->flush();
        }

        return $job;
    }

    /**
     *
     * @return \Doctrine\ORM\EntityManagerInterface em
     */
    protected function getEM()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getContainer()->get("doctrine.orm.entity_manager");
        }
        return $this->entityManager;
    }

    /**
     * @return SettingRepository
     */
    public function getSettings(): SettingRepository
    {
        if (!$this->settings) {
            $this->settings = $this->getContainer()->get('amulen.dashboard.service.setting');
        }

        return $this->settings;
    }

    public function log($msg)
    {

    }

}
