<?php 

//Reference: https://github.com/o/sitemap-php

$sitemap = new Sitemap('http://www.jingwentian.com');
$sitemap->setPath('sitemap/'); 
$sitemap->setFilename('sitemap');

$data_items = $db->select('articles',['id'],[
	'LIMIT' => [0,400000]
]);

foreach ($data_items as &$value) {
	$sitemap->addItem('/article/' . $value['id'].'/' , '1.0', 'daily', 'Today');
} 

$sitemap->createSitemapIndex('http://www.jingwentian.com/', 'Today'); 
