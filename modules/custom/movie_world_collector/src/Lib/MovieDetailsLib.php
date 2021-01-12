<?php


namespace Drupal\movie_world_collector\Lib;


class MovieDetailsLib
{
  //если какой-то параметр пуст (null) добавляем в базу WP замещающее слово, например 'неизвестно'
  public static function checkAvailability($type, $substitute_word, $response): string
  {
    return (!empty($response[$type])) ? $response[$type] : $substitute_word;
  }


  //форматируем финансы для красивого вывода
  public static function prepareFinance($type, $substitute_word, $response): string
  {
    return (!empty($response[$type])) ? '$'.number_format($response[$type], 0, "", ", ") : $substitute_word;
  }


  //форматируем время для красивого вывода
  public static function prepareRuntime($type, $substitute_word, $response): string
  {
    if (empty($response[$type]))
      return $substitute_word;
    $runtime = $response[$type];
    return $runtime.' мин. / '.floor($runtime / 60) .' ч. '. $runtime % 60 .' мин.';
  }


  //форматируем массив с данными для красивого вывода
  public static function extractArrayParam($type, $subtype, $substitute_word, $response): string
  {
    if (empty($response[$type]))
      return $substitute_word;
    $param = '';
    foreach ($response[$type] as $key => $value) {
      $param .= $value[$subtype].' ';
    }
    return str_replace(' ', ', ', trim($param));
  }
}
