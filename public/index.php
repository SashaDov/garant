<?php

use Common\ARWrap;
use Article\Repository;
use Article\Utils;
use Author\Authors;
use Common\Menu;

//echo "Test_1";
require_once "Common/AbstractRepository.php";
require_once "Common/ARWrap.php";
require_once "Article/Repository.php";
require_once "Article/Utils.php";
require_once "Author/Authors.php";
require_once "Common/Menu.php";


//$ob = new ARWrap;
//$sql = "SELECT * FROM Article";
//$test_2 = $ob->getMany($sql);

//$ob2 = new Repository();
//$test_3 = $ob2->getLatest(10);

/*
 * $text = 'Метод принимает в качестве <a href="http://www.garant.ru/company/about/">О компании2</a> текст статьи текст статьи
 <a class="link" href="http://www.garant.ru/company/about/" title="О компании">О компании3</a> текст статьтекст статьи <a class="link" href="http://www.garant.ru/company/about/" title="О компании">О компании4</a> текст стать';
$test_4 = Utils::convertLinks($text);
*/
$ob3 = new Authors;
//$test_5 = $ob3->queryCoAuthors();
//$test_6 = $ob3->getMasAu();
//$test_7 = $ob3->getMasAr();
$authorship = $ob3->getCouplesAuthors();

$ob4 = new Menu;
$linear = require_once "Common/linear_menu.php";

$test_9 = $ob4->getTree($linear);






?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test</title>
</head>
<body>
<pre>

<?= var_dump($test_9)?>
</pre>

<?php


     foreach ($authorship as $author => $coauthors) {
         foreach ($coauthors as $coauthor) {
             echo $author, ', ', $coauthor, "<br>\r\n";
         }
     }

$template = <<<EOT
<article>
    <h2 class="title">%d %s</h2>
    <div class="text">%s</div>
    <h4 class="author">%s, %s</h4>
    <div class="tags">%s</div>
</article>
EOT;

$repository = new Repository();
foreach ($repository->getLatest(10) as $article) {
echo sprintf($template,
$article['article_id'],
$article['title'],
Utils::convertLinks($article['text']),
$article['created'],
$article['name'],
$article['q2.tags']
);
}
?>
</body>
</html>








































