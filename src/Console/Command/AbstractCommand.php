<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace Console\Command;

use Console\Config;
use Console\Container;
use Console\Entity;
use Console\Processor\ProcessorInterface;
use Console\Queue\QueueInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
  /**
   * @var InputInterface
   */
  protected $input;

  /**
   * @var OutputInterface
   */
  protected $output;

  protected $container;

  /**
   * @return \Symfony\Component\Console\Input\InputInterface
   */
  public function getInput()
  {
    return $this->input;
  }

  /**
   * @return \Symfony\Component\Console\Output\OutputInterface
   */
  public function getOutput()
  {
    return $this->output;
  }

  protected function configure()
  {
    $this->addOption('path_to_config', 'p', InputOption::VALUE_OPTIONAL, 'Path to config', './App/Config/config.yml');
    $this->addOption('env', 'e', InputOption::VALUE_OPTIONAL, 'Environment', '');
  }

  /**
   * @return Container
   */
  public function getContainer()
  {
    $container = Container::getInstance();

    if(!$container->has('console.command'))
    {
      $container->register('console.command', $this);
    }

    if(!$container->has('console.logger'))
    {
      $container->register('console.logger', $this->getOutput());
    }

    return $container;
  }

  /**
   * @return QueueInterface
   */
  public function getQueue()
  {
    return $this->getContainer()->get('console.queue');
  }

  /**
   * @return ProcessorInterface
   */
  public function getProcessor()
  {
    return $this->getContainer()->get('console.processor');
  }

  /**
   * @return OutputInterface
   */
  public function getLogger()
  {
    return $this->getContainer()->get('console.logger');
  }

  protected function preExecute()
  {
    $pathToFile = $this->getInput()->getOption('path_to_config');
    $env = $this->getInput()->getOption('env');
    $this->getContainer()->init(new Config($pathToFile, $env));
    return true;
  }

  protected function postExecute()
  {

  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $this->input = $input;
    $this->output = $output;

    if(!$this->preExecute())
    {
      return false;
    }

    $this->doExecute($input, $output);

    $this->postExecute();
  }

  protected function doExecute()
  {
    if($task = $this->getQueue()->getNext())
    {
      $this->getProcessor()->processTask($task);
    }
  }

  protected function log($string)
  {
    $this->getLogger()->writeln($string);
  }

} 