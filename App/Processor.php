<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace App;

use Console\Container;
use Console\Processor\ProcessorInterface;
use Console\Entity\Task\TaskInterface;

class Processor implements ProcessorInterface
{
  public function processTask(TaskInterface $task)
  {
    Container::getInstance()->get('console.logger')->writeln($task->getName());
  }
}