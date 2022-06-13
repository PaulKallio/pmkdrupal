<?php

namespace Drupal\hello_world;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Prepares the salutaion to the world.
 */
class HelloWorldSalutation {

  use StringTranslationTrait;

  /**
   * Configuration Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * HelloWorldSalutaion constructor.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Returns the salutaion.
   */
  public function getSalutation() {

    \Drupal::logger('hello_world')->notice('hello_world->getSalutation()');

    $config = $this->configFactory->get('hello_world.custom_salutation');
    $salutation = $config->get('salutation');
    if ($salutation !== "" && $salutation) {
      return $salutation;
    }

    $time = new \DateTime();
    if ((int) $time->format('G') >= 00 && (int) $time->format('G') < 12) {
      return $this->t('Good morning world');
    }

    if ((int) $time->format('G') >= 12 && (int) $time->format('G') <= 18) {
      return $this->t('Good afternoon world');
    }

    if ((int) $time->format('G') >= 18) {
      return $this->t('Good evening world');
    }
  }

}
