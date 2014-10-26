<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace Console;

use Symfony\Component\Yaml\Yaml;

class Config
{
  const ENV_ALL = 'all';

  protected $path;
  protected $env;
  protected $options = array();

  function __construct($path, $env)
  {
    $this->path = $path;
    $this->env  = $env;

    $this->init();
  }

  /**
   * @return mixed
   */
  public function getEnv()
  {
    return $this->env;
  }

  protected function init()
  {
    $config = Yaml::parse($this->path);

    if (isset($config[static::ENV_ALL]) && is_array($config[static::ENV_ALL])) {
      $this->options = $config[static::ENV_ALL];
    }

    if ($this->getEnv() && isset($config[$this->getEnv()]) && is_array($config[$this->getEnv()])) {
      $this->add($config[$this->getEnv()]);
    }
  }

  protected static function deepMerge(array $a, array $b)
  {
    $result = $a;

    foreach($b as $key => $value)
    {
      if(isset($result[$key]) && is_array($result[$key]) && is_array($value))
      {
        $result[$key] = static::deepMerge($result[$key], $value);
      } else {
        $result[$key] = $value;
      }
    }

    return $result;
  }

  public function add($options)
  {
    $this->options = static::deepMerge($this->options, $options);
  }

  public function get($name)
  {
    return isset($this->options[$name]) ? $this->options[$name] : null;
  }
}