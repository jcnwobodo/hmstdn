<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/4/2015
 * Time:    11:24 PM
 */

function recursive_implode($glue, $pieces)
{
    $build = array();
    foreach($pieces as $piece)
    {
        $build[] = is_array($piece) ? recursive_implode($glue, $piece) : ( is_object($piece) ? print_r($piece,true) : $piece);
    }
    return implode($glue, $build);
}

function format_text($raw_text)
{
    $all_paragraphs = explode("\n", $raw_text);
    $valid_paragraphs = array();
    foreach($all_paragraphs as $paragraph){if(strlen($paragraph)) $valid_paragraphs[] = $paragraph;}
    $formatted_text = '<p>'.implode('</p><p>', $valid_paragraphs).'</p>';

    return $formatted_text;
}

function remove_text_formatting($formatted_text)
{
    $raw_text = str_replace("</p><p>","\n", $formatted_text);
    $raw_text = str_replace(array("<p>","</p>"), array("",""), $raw_text);
    return $raw_text;
}

function preProcessTimeArr(array &$time)
{
    $time['hour'] = (strtolower($time['am_pm'])=='pm' and $time['hour']!=12)? ($time['hour']+12) : $time['hour'];
    $time['hour'] = (strtolower($time['am_pm'])=='am' and $time['hour']==12)? 0 : $time['hour'];
}

function num_words($string)
{
    $raw_words = explode(" ", $string);
    $processed_words = array();
    foreach($raw_words as $raw_word){if(strlen($raw_word)) $processed_words[] = $raw_word;}
    return sizeof($processed_words);
}

function subwords($string, $start, $length)
{
    $words = explode(' ', $string);
    $return = array();
    $limit = sizeof($words);
    $start = $start <= $limit ? $start : 0;
    $len = $length <= ($limit - $start) ? $length : ($limit - $start);

    for($i = 0, $p = $start; $i < $len; ++$i, ++$p)
    {
        $return[] = $words[$p];
    }
    return implode(' ', $return);
}
