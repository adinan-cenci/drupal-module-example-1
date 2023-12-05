<?php
namespace Drupal\star_wars\Service;

use Psr\Http\Client\ClientInterface;

class StarWarsApi {

  /**
   * @var \Psr\Http\Client\ClientInterface
   *   Http client.
   */
  protected ClientInterface $httpClient;

  const BASE_HREF = 'https://swapi.dev/api/';

  /**
   * @param \Psr\Http\Client\ClientInterface $http_client
   *   Http client.
   */
  public function __construct(ClientInterface $http_client) {
    $this->httpClient = $http_client;
  }

  /**
   * @param int $character_id
   *   Character unique identifier.
   *
   * @return \stdClass|NULL
   *   The api data.
   */
  public function getCharacterById(int $character_id) : ?\stdClass {
    return $this->getJson(self::BASE_HREF . 'people/' . $character_id);
  }

  /**
   * Makes http request to the api and returns the response's body.
   *
   * @param string $uri
   *   The api URI.
   *
   * @return \stdClass|NULL
   *   The api data.
   */
  protected function getJson(string $uri) : ?\stdClass {
    $response = $this->httpClient->get($uri);

    if ($response->getStatusCode() != 200) {
      return NULL;
    }

    $body = $response->getBody();
    $json = (string) $body;
    $data = json_decode($json);

    return $data;
  }

}

// Drupal::service('star_wars.api')->getCharacterById(1)