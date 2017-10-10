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
		<input type="text" class="amount_field" placeholder="Amount of news">
		<button class="redirect_but but">GO!</button>
	</div>
</div>

<?php if (!isset($_GET['pages']) || intval($_GET['pages']) <= 0) : ?>
<div class="pravda">
	<div class="pravda__text">Чтобы начать поиск новостей введите количество и нажмите GO!</div>
	<img src="img/pravda-man.jpg" alt="pravda-man">
</div>
<?php endif; ?>

<?php 

include "simple_html_dom.php";
include "NewsClass.php";

$html = file_get_html('http://www.pravda.com.ua/rus/news/');
$main = $html->find('div[class=news_all]')[0];
$amount = isset($_GET['pages']) ? $_GET['pages'] : 0;
$n = 1;
$news = [];
foreach ($main->children as $key => $value) {
	$class = new NewsClass();
	$class->create_news($value, $n);
	$news[] = $class;
	if($n >= $amount)
		break;
	$n++;
}
$html->clear(); 
unset($html);
?>

<?php if (isset($_GET['pages']) && intval($_GET['pages']) > 0) : ?>
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
			<?php foreach ($news as $key => $news) : ?>
				<tr class="<?= $news->class ?>">
					<td><?= $news->n; ?></td>
					<td><?= $news->parse_t; ?></td>
					<td><?= $news->time; ?></td>
					<td><?= $news->title; ?></td>
					<td><?= $news->subtitle; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="save_database">
		<button class="save_but but">Save to Database</button>
	</div>
</div>

<?php endif; ?>

</html>

<script src="js/scripts.js"></script>
</body>