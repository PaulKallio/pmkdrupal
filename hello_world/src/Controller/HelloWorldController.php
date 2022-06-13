<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\hello_world\HelloWorldSalutation;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for the hello message.
 */
class HelloWorldController extends ControllerBase {

  /**
   * Hello World salutation text.
   *
   * @var \Drupal\hello_world\HelloWorldSalutaion
   */
  protected $salutation;

  /**
   * Hello world controller constructor.
   *
   * @param \Drupal\hello_world\HelloWorldSalutation $salutation
   *   Salutation text.
   */
  public function __construct(HelloWorldSalutation $salutation) {
    $this->salutation = $salutation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('hello_world.salutation')
    );
  }

  /**
   * Hello World.
   *
   * @return array
   *   Our message.
   */
  public function helloWorld() {

    return [
      '#markup' => $this->salutation->getSalutation(),
    ];
  }

}
