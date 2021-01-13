<?php


namespace Drupal\movie_world_collector\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\movie_world_collector\Lib\MoviesListLib as MLL;
use Drupal\movie_world_collector\Service\TMDbAPI;

class MoviesListController extends ControllerBase
{

  public function content($page)
  {
    $api = new TMDbAPI();

    $response = $api->getMovieInfo(
      'cd3ba6c292fd0d68c2c409d5ddbbc1f3',
      'popular',
      'ru-RU',
      $page
    );

    if ($response === false)
      return [];

    //генрируем ссылки на первые 100 страниц топа
    $build = MLL::pagesGenerator(1, 100, $page);

    $build .= '<section class="regular slider">';

    foreach ($response['results'] as $movie) {

      $title  = MLL::titlePrepare($movie['title'], 15, 7);
      $poster = 'https://image.tmdb.org/t/p/w342' . $movie['poster_path'];
      $link   = $GLOBALS['base_url'] . '/movie/details/' . $movie['id'];
      $date   = MLL::datePrepare($movie['release_date'], 'неизвестно');
      $vote   = '<b>' . $movie['vote_average'] . '</b> [ ' . $movie['vote_count'] . ' ] ';

      $build .= '
        <div>
            <h1><a href="'. $link .'" target="_blank">' . $title . '</a></h1>
            <a href="'. $link .'" target="_blank"><img src="' . $poster . '" alt="Movie Poster"></a>
            <div class="movie-info-bottom">
                <span class="date">' . $date . '</span>
                <span class="budget">' . $vote . '</span>
            </div>
        </div>
      ';

    }

    $build .= '</section>';

    //генрируем ссылки на последние 100 страниц топа
    $build .= MLL::pagesGenerator(101, 200, $page);

    return ['#markup' => $build];
  }

}

