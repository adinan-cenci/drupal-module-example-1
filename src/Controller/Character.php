<?php
namespace Drupal\star_wars\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\star_wars\Service\StarWarsApi;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Character extends ControllerBase {

  /**
   * @var Drupal\star_wars\Service\StarWarsApi
   *   Star Wars api.
   */
  protected StarWarsApi $starWarsApi;

  /**
   * Constructor.
   *
   * @param Drupal\star_wars\Service\StarWarsApi $star_wars_api
   *   Local file manager.
   */
  public function __construct(StarWarsApi $star_wars_api) {
    $this->starWarsApi = $star_wars_api;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('star_wars.api'));
  }

  /**
   * @param int $id
   */
  public function characterPage(int $id) {

    $character = $this->starWarsApi->getCharacterById($id);

    return [
      '#theme' => 'star_wars_character',
      '#character' => $character,
    ];
  }

}
