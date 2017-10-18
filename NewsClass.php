<?php

class NewsClass
{
	public $class;
	public $time;
	public $title;
	public $href;
	public $subtitle;
	public $n;
	public $parse_t;

	public function __construct($news, $n)
	{
		$href = $news->find('div[class=article__title]', 0)->find('a', 0)->href;

		if (preg_match("#^/.#", $href)) 
			$this->href = "http://www.pravda.com.ua" . $href;
		else
			$this->href = $href;
		
		$this->class = $news->attr['class'];
		$this->time = $news->find('div[class=article__time]', 0)->innertext;
		$this->title = $news->find('div[class=article__title]', 0)->find('a', 0)->innertext;
		$this->subtitle = $news->find('div[class=article__subtitle]', 0)->innertext;
		$this->n = $n;
		$this->parse_t = date("d/m/y h:m:s", time());
	}
}