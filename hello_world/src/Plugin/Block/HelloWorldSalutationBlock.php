<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\hello_world\HelloWorldSalutation;

/**
 * HelloWorldSalutation Block.
 *
 * @Block (
 *  id = "hello_world_salutation_block",
 *  admin_label = @Translation("Hello World Salutation"),
 * )
 */
class HelloWorldSalutationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The salutation service.
   *
   * @var \Drupal\hello_world\HelloWorldSalutation
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, HelloWorldSalutation $salutation) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->salutation = $salutation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
      ContainerInterface $container,
      array $configuration,
      $plugin_id,
      $plugin_definition) {
    return new static(
                $configuration,
                $plugin_id,
                $plugin_definition,
                $container->get('hello_world.salutation'));

  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->salutation->getSalutation(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'enabled' => 1,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#description' => $this->t('Check this box if you want to enable this feature.'),
      '#default_value' => $config['enabled'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] = $form_state->getValue('enabled');
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {

    $title = $form_state->getValue('subject');

    if (empty($title)) {
      return;
    }
    if (strlen($title) < 5) {
      $form_state->setErrorByName('subject', $this->t('Title is too short.'));
    }
    elseif (strlen($title) > 30) {
      $form_state->setErrorByName('subject', $this->t('Title is too long.'));
    }
    else {
      $form_state->clearErrors();
    }
  }

}
