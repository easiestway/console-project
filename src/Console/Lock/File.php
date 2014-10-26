<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace Console\Lock;


use Symfony\Component\OptionsResolver\OptionsResolver;

class File implements LockInterface
{
  protected $fileName;

  function __construct($options = array())
  {
    $resolver = new OptionsResolver();
    $resolver->setRequired('filename');

    $options = $resolver->resolve($options);

    $this->fileName = $options['filename'];
  }

  public function getFileName()
  {
    return $this->fileName;
  }

  public function isLocked()
  {
    return file_exists($this->getFileName());
  }

  public function lock()
  {
    touch($this->getFileName());
  }

  public function unlock()
  {
    $this->isLocked() and unlink($this->getFileName());
  }

} 