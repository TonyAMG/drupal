<?php


namespace Drupal\movie_world_collector\Service;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TMDbAPI
{

  protected $httpClient;

  public function __construct()
  {
    $http_client = new Client(['verify' => false ]);
    $this->httpClient = $http_client;
  }

  public function getMovieInfo(
    $api_key,
    $type = 'popular',
    $lang = 'ru-RU',
    $page = '',
    $movie_id = ''
  )
  {

    switch ($type) {
      case 'popular':
        $request_part = 'popular';
        $page = '&page='.$page;
        break;
      case 'movie_details':
        $request_part = $movie_id;
        break;
      case 'movie_credits':
        $request_part = $movie_id.'/credits';
        break;
    }

    $endpoint_url =
      'https://api.themoviedb.org/3/movie/'
      . $request_part . '?api_key=' . $api_key . '&language=' . $lang . $page;


    try {
      $response = $this->httpClient->request('GET', $endpoint_url);
    } catch (GuzzleException $e) {
      $request_error = true;
    }


    $movies = (empty($request_error))
      ? json_decode($response->getBody()->getContents(), true)
      : false;


    return $movies;
  }
}


