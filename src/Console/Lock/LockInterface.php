<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace Console\Lock;


interface LockInterface {
  public function isLocked();
  public function lock();
  public function unlock();
}