<?php


namespace Drupal\movie_world_collector\Lib;


class MoviesListLib
{


  //генератор архива страниц
  public static function pagesGenerator($page_min, $page_max, $page): string
  {
    $pages_list = '';

    for ($i = $page_min; $i <= $page_max; $i++) {
      if ($page == $i) {
        $pages_list .= ' <b>[ '. $i .' ]</b>';
      } else {
        $pages_list .= ' <a href="'. $GLOBALS['base_url'] . '/movies/list/' .$i. '">  [ '. $i .' ]</a>';
      }
    }

    return $pages_list;
  }


  //делаем красивую дату
  public static function datePrepare($date_raw, $substitute_word): string
  {
    if (empty($date_raw))
      return $substitute_word;
    $date_arr = explode('-', $date_raw);
    return '<b>' . $date_arr[0] . '</b>' . '-' . $date_arr[1]. '-' . $date_arr[2];
  }


  //делаем красивые заголовки:
  //* отсекаем лишнюю длину (для иероглифов отсекаем еще больше)
  //* добавляем '...' в конце усеченных заголовков
  public static function titlePrepare($title, $max_length, $max_length_cjk_characters): ?string
  {
    $chinese  = '\p{Han}+';
    $japanese = '\x{4E00}-\x{9FBF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}';
    $korean   = '\x{3130}-\x{318F}\x{AC00}-\x{D7AF}';

    //определяем если заголовок на китайском, японском, или корейском
    if(preg_match("/([$japanese]|[$korean]|$chinese)/u", $title))
      $max_length = $max_length_cjk_characters;

    //обрезаем до указанной длины, добавляем '...' если нужно
    $title_raw = mb_substr($title, 0, $max_length);
    return (mb_strlen($title_raw) > ($max_length - 1)) ? $title_raw . '...' : $title_raw;
  }

}



