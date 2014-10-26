<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace Console\Queue;

use Console\Entity\Task\TaskInterface;

interface QueueInterface {
  /**
   * @return TaskInterface
   */
  public function getNext();
} 