<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace Console\Command;


use Console\Lock\LockInterface;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractLockCommand extends AbstractCommand
{
  protected function configure()
  {
    parent::configure();
    $this->addOption('unlock', 'u', InputOption::VALUE_NONE, 'Ignore lock state');
  }

  /**
   * @return LockInterface;
   */
  public function getLock()
  {
    return $this->getContainer()->get('console.lock');
  }

  protected function preExecute()
  {
    $preExecute = parent::preExecute();

    if(!$preExecute)
    {
      return false;
    }

    if($this->getInput()->getOption('unlock'))
    {
      return true;
    }


    $lock = $this->getLock();

    if($lock->isLocked())
    {
      $this->log('Task already in progress');
      return false;
    }

    $lock->lock();

    return $preExecute;
  }

  protected function postExecute()
  {
    parent::postExecute();
    $this->getLock()->unlock();
  }

}