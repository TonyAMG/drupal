<?php


namespace Drupal\movie_world_collector\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\movie_world_collector\Lib\MovieDetailsLib as SCL;
use Drupal\movie_world_collector\Service\TMDbAPI;

class MovieDetailsController extends ControllerBase
{

  public function content($movie)
  {
    $api = new TMDbAPI();

    $response = $api->getMovieInfo(
      'cd3ba6c292fd0d68c2c409d5ddbbc1f3',
      'movie_details',
      'ru-RU',
      '',
      $movie
    );

    if ($response === false)
      return [];

    $movie = $response;

    $title          = SCL::checkAvailability('title', 'отсутствует', $movie);
    $original_title = SCL::checkAvailability('original_title', 'отсутствует', $movie);
    $poster         = SCL::checkAvailability('poster_path', 'отсутствует', $movie);
    $release_date   = SCL::checkAvailability('release_date', 'неизвестно', $movie);
    $overview       = SCL::checkAvailability('overview', 'Отсутствует', $movie);
    $genres         = SCL::extractArrayParam('genres', 'name', 'неизвестно', $movie);
    $product_countr = SCL::extractArrayParam('production_countries', 'iso_3166_1', 'неизвестно', $movie);
    $budget         = SCL::prepareFinance('budget', 'неизвестно', $movie);
    $revenue        = SCL::prepareFinance('revenue', 'неизвестно', $movie);
    $runtime        = SCL::prepareRuntime('runtime', 'неизвестно', $movie);

    $build = '
      <div class="mwc-module-movie-details-page">
        <h1 class="mwc-module-movie-title">' . $title . '</h1>
        <div class="mwc-module-movie-original-title">' . $original_title . '</div>
        <div class="mwc-module-movie-logo-column">
          <img src="https://image.tmdb.org/t/p/w342' . $poster . '" alt="Movie Poster">
        </div>
        <div class="mwc-module-movie-details-column">
          <span class="mwc-module-movie-desc-headers">Релиз: &nbsp;</span>
          <span class="mwc-module-movie-desc">' . $release_date . '</span>
          <br>
          <span class="mwc-module-movie-desc-headers">Бюджет: &nbsp;</span>
          <span class="mwc-module-movie-desc">' . $budget . ' </span>
          <br>
          <span class="mwc-module-movie-desc-headers">Сборы: &nbsp;</span>
          <span class="mwc-module-movie-desc">' . $revenue . ' </span>
          <br>
          <span class="mwc-module-movie-desc-headers">Жанр: &nbsp;</span>
          <span class="mwc-module-movie-desc">' . $genres . '</span>
          <br>
          <span class="mwc-module-movie-desc-headers">Время: &nbsp;</span>
          <span class="mwc-module-movie-desc">' . $runtime . '</span>
          <br>
          <span class="mwc-module-movie-desc-headers">Страна: &nbsp;</span>
          <span class="mwc-module-movie-desc">' . $product_countr . '</span>
        </div>
        <div class="mwc-module-movie-overview-column">
           ' . $overview . '
        </div>
      </div>
      ';

    return ['#markup' => $build];
  }

}


