<?php
/**
 * Created by PhpStorm.
 * User: Галина
 * Date: 09.08.2017
 * Time: 16:02
 */

namespace Article;


use Common\ARWrap;

class Repository extends ARWrap
{

    public function getLatest($limit)
    {
        $sql = "SELECT q1.*, q2.tags FROM (SELECT a.article_id, au.name, a.title, a.text, a.created FROM ((AuthorArticle AS aa INNER JOIN Author AS au ON au.author_id = aa.author_id) INNER JOIN Article AS a ON a.article_id = aa.article_id) WHERE contribution >= (SELECT max(contribution) FROM AuthorArticle GROUP BY article_id) ) q1 LEFT JOIN (SELECT a.article_id, group_concat(t.name) as tags FROM (( ArticleTag AS at inner JOIN Article AS a ON a.article_id = at.article_id) INNER JOIN Tag as t ON t.tag_id = at.tag_id) GROUP BY at.article_id) q2 ON q1.article_id = q2.article_id ORDER BY created DESC LIMIT  ".$limit;

        return $this->getMany($sql);
    }
}