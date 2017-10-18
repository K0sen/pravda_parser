<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pravda Parser</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/favicon.ico">
</head>
<body>

<div class="header">
	<div class="title">Pravda Search</div>
	<div class="search">
		<form method="get" class="search__form">
			<input type="text" name="pages" class="amount_field" placeholder="Amount of news">
			<button class="redirect_but but">GO!</button>
		</form>
	</div> 
</div>

<!-- 
Simple parser of news site "www.pravda.com.ua". To start search user have to 
enter amount of news. Then we do the parsing of news site and display news.
If in url no get param "pages" with positive number we show hust a start page
-->

<?php if (!isset($_GET['pages']) || intval($_GET['pages']) <= 0) : ?>

<div class="pravda">
	<div class="pravda__text">Чтобы начать поиск новостей введите количество и нажмите GO!</div>
	<img src="img/pravda-man.jpg" alt="pravda-man">
</div>

<?php else :

include "simple_html_dom.php";
include "NewsClass.php";

$html = file_get_html('http://www.pravda.com.ua/rus/news/');
$main = $html->find('div[class=news_all]')[0];
$amount = isset($_GET['pages']) ? $_GET['pages'] : 0;		// amount of news
$counter = 1;
$news = [];													// array that storage all news with $count amount
foreach ($main->children as $key => $value) {
	$class = new NewsClass($value, $counter);
	$news[] = $class;
	if($counter >= $amount)
		break;
	$counter++;
}
$html->clear(); 
unset($html);

?>

<div class="preloader">
	<img src="img/preload.gif" alt="preloader">
</div>

<div class="news">
	<div class="clear">
		<button class="clear_but but">CLEAR PAGE</button>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Parse time</th>
				<th>News Time</th>
				<th>Title</th>
				<th>Subtitle</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($news as $key => $one_news) : ?>
				<tr class="<?= $one_news->class ?>">
					<td>
						<div class="article__number"><?= $one_news->n; ?></div>
					</td>
					<td>
						<div class="artucle__parse_t"><?= $one_news->parse_t; ?></div>
					</td>
					<td>
						<div class="article__time"><?= $one_news->time; ?></div>
					</td>
					<td>
						<div class="article__title">
							<a href="<?= $one_news->href; ?>" target="_blank"><?= $one_news->title; ?></a>
						</div>
					</td>
					<td>
						<div class="article__subtitle"><?= $one_news->subtitle; ?></div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php endif; ?>

</html>

<script src="js/scripts.js"></script>
</body>