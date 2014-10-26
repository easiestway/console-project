<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace App\Command;

use Console\Queue\QueueInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TaskCommand extends \Console\Command\AbstractLockCommand
{
  protected function configure()
  {
    parent::configure();

    $this
        ->setName('task:demo')
        ->setDescription('Demo')
        ->addArgument(
            'name',
            InputArgument::OPTIONAL,
            'Queue Name',
            'default'
        );
  }

  public function getQueue()
  {
    $queue = parent::getQueue();

    $queue->setName($this->getInput()->getArgument('name'));

    return $queue;
  }


}