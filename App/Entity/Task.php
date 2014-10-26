<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace App\Entity;


use Console\Entity\Task\TaskInterface;

class Task implements TaskInterface
{
  protected $name;

  function __construct($name)
  {
    $this->name = $name;
  }

  /**
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }

}