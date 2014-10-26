<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace Console;


class Container
{
  /**
   * @var Container
   */
  protected static $instance = null;

  protected $options = null;

  /**
   * @return Container
   */
  public static function getInstance()
  {
    if(is_null(static::$instance))
    {
      static::$instance = new static();
    }

    return static::$instance;
  }

  protected $services = array();

  public function register($name, $instance)
  {
    $this->services[$name] = $instance;
  }

  /**
   * @param $name
   * @return mixed
   * @throws Exception
   */
  public function get($name)
  {
    if(!isset($this->services[$name]) && isset($this->options[$name]))
    {
      $this->services[$name] = $this->makeService($this->options[$name]);
    }

    if(!isset($this->services[$name]) || !$this->services[$name])
    {
      throw new Exception("Service {$name} has not been found");
    }

    return $this->services[$name];
  }

  public function has($name)
  {
    return isset($this->services[$name]) || $this->options[$name];
  }

  public function init(Config $config)
  {
    $this->options = $config->get('container');
  }

  protected function makeService($options)
  {
    $instance = null;

    if(is_string($options))
    {
      if(!class_exists($options))
      {
        throw new Exception("Class {$options} does not exists");
      }

      $instance = new $options;
    }

    if(is_array($options) && isset($options['class']))
    {
      if(!class_exists($options['class']))
      {
        throw new Exception("Class {$options['class']} does not exists");
      }

      $parameters = isset($options['parameters']) ? $options['parameters'] : null;

      if($parameters)
      {
        $instance = new $options['class']($parameters);
      } else {
        $instance = new $options['class'];
      }
    }

    return $instance;
  }

} 