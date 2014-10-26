<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace Console\Processor;


use Console\Entity\Task\TaskInterface;

interface ProcessorInterface {
  public function processTask(TaskInterface $task);
} 