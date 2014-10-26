<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace App;


use Console\Lock\LockInterface;

class Lock implements LockInterface
{
  public function isLocked()
  {
    return false;
  }

  public function lock()
  {
    // TODO: Implement lock() method.
  }

  public function unlock()
  {
    // TODO: Implement unlock() method.
  }


} 