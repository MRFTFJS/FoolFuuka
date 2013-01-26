<?php

namespace Foolfuuka\Themes\Fuuka;

if ( ! defined('DOCROOT'))
	exit('No direct script access allowed');

class Theme_Fu_Fuuka
{
	public static function greentext($result)
	{
		$html= '\\1<span class="greentext">\\2</span>\\3';;
		$result->setParam('html', $html)->set($html);
	}

	public static function processInternalLinksHtml($result)
	{
		$data = $result->getParam('data');
		$html = [
			'tags' => ['<span class="unkfunc">', '</span>'],
			'hash' => '',
			'attr' => 'class="backlink" onclick="replyHighlight(' . $data->num . ');"',
			'attr_op' => 'class="backlink"',
			'attr_backlink' => 'class="backlink"',
		];
		
		$result->setParam('build_url', $html)->set($html);
	}

	public static function processExternalLinksHtml($result)
	{
		$data = $result->getParam('data');
		$html = [
			'tags' => ['open' =>'<span class="unkfunc">', 'close' => '</span>'],
			'short_link' => '//boards.4chan.org/'.$data->shortname.'/',
			'query_link' => '//boards.4chan.org/'.$data->shortname.'/res/'.$data->query,
			'backlink_attr' => 'class="backlink"'
		];

		$result->setParam('build_url', $html)->set($html);
	}
}