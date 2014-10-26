<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace App;


use Console\Queue\QueueInterface;
use Console\Entity\Task\TaskInterface;

class Queue implements QueueInterface
{
  protected $name = null;

  /**
   * @param null $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * @return null
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return TaskInterface
   */
  public function getNext()
  {
    return new \App\Entity\Task($this->getName());
  }

} 