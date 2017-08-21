<?php
/**
 * Created by PhpStorm.
 * User: Галина
 * Date: 09.08.2017
 * Time: 16:02
 */

namespace Article;


class Utils
{

    //$text = 'текст статьи <a class=\"link\" href=\"http://www.garant.ru/company/about/\" title=\"О компании\">О компании</a> текст статьи';

    public static function convertLinks ($text)
    {
        $pattern = "/<a(?:.*)?(?:href=(?:\"|'))([^\"']{2,})(?:\"|')(?:.*)?>(.+)<\/a>/Ui";
        $replacement = '"$2":$1';
        if (preg_match($pattern,$text))
        {
            return preg_replace($pattern,$replacement,$text);
        }
        return $text;
    }
}