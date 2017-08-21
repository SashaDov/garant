<?php
/**
 * Created by PhpStorm.
 * User: Галина
 * Date: 11.08.2017
 * Time: 23:20
 */

namespace Author;


use Common\ARWrap;

class Authors extends ARWrap
{

    protected static $authors = [];

    protected static $articles_part = [];

    protected function infoAuthorsWithArticles ()
    {
        $array = $this->queryInfoAuthorsWithArticles();

        foreach ($array as $strarr) {
            $author_id = $strarr['author_id'];
            $author_name = $author_id.'__'.$strarr['name'];
            self::$authors[$author_id] = $strarr['name'];
            $articles_id = explode(',', $strarr['article_num']);
            $contributions = explode(',', $strarr['contribution']);
            $i = 0;
            foreach ($articles_id as $article_id) {
                self::$articles_part[$author_name][$article_id] = $contributions[$i];
                $i++;
            }
        }
    }

    public function getCouplesAuthors ()
    {
        $this->infoAuthorsWithArticles();
        $authorship = [];
        $copy_articles_part = self::$articles_part;
        foreach (self::$articles_part as $num_author => $author_articles)
        {
            array_shift($copy_articles_part);
            if (!empty($copy_articles_part))
            {
                $coauthors_current_author = [];
                foreach ($copy_articles_part as $next_author => $author_next_articles)
                {
                    if (!empty(array_intersect_key($author_articles,$author_next_articles)))
                    {
                        $coauthors_current_author[] = $next_author;
                    }
                }
                if (!empty($coauthors_current_author))
                {
                    $authorship[$num_author] = $coauthors_current_author;
                }
            }
        }
        return $authorship;
        /*
        // $mas1 = [$au1=>[$c1,c2,c3],$au2=>[$c3,$c5]...];

        1=>Ivan,2=>Petr,3=>Isidor...
        1=>[1=>33],2=>[3=>30],3=>[1=>34,5=>60]...

        //есть два варианта - извлечь по подмассивам: автор - соавторы отдельным запросом или вытащить по sql
        готовые пары
        1=>3,1=>4,2=>5,3=>1,4=>1,3=>5,3=>4,4=>3,5=>2,5=>3
        1=>3,1=>4,2=>5,3=>5,3=>4
        */
    }

    protected function queryInfoAuthorsWithArticles ()
    {
        //WHERE contribution < 100 - без этого более универсальный вариант
        $sql = "SELECT a1.name, a1.author_id, group_concat(aa.article_id) AS article_num, group_concat(aa.contribution) AS contribution FROM Author AS a1 LEFT JOIN AuthorArticle AS aa ON a1.author_id = aa.author_id GROUP BY a1.author_id";
        return $this->getMany($sql);
    }

    public function getMasAu ()
    {
        $this->infoAuthorsWithArticles();
        return self::$authors;
    }

    public function getMasAr ()
    {
        $this->infoAuthorsWithArticles();
        return self::$articles_part;
    }



}