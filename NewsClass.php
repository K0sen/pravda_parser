<?php

class NewsClass
{
	public $class;
	public $time;
	public $title;
	public $href;
	public $subtitle;
	public $n;
	public $pars_t;

	public function create_news($news, $n)
	{
		$time = date("d/m/y h:m:s", time());
		$href = $news->find('div[class=article__title]', 0)->find('a', 0)->href;

		if (preg_match("#^/.#", $href)) 
			$this->href = "http://www.pravda.com.ua" . $href;
		else
			$this->href = $href;
		
		$this->class = $news->attr['class'];
		$this->time = $news->find('div[class=article__time]', 0)->outertext;
		$title = $news->find('div[class=article__title]', 0);
		$title->find('a', 0)->href = $this->href;
		$title->find('a', 0)->target = "_blank";
		$this->title = $title->outertext;
		$this->subtitle = $news->find('div[class=article__subtitle]', 0)->outertext;
		$this->n = "<div class=\"article__number\">{$n}</div>";
		$this->parse_t = "<div class=\"article__parse_time\">{$time}</div>";
	}
}