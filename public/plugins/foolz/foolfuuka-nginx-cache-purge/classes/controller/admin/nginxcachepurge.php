<?php

namespace Foolfuuka\Plugins\NginxCachePurge;

if ( ! defined('DOCROOT'))
	exit('No direct script access allowed');

class ControllerPluginFuNginxCachePurgeAdminNginxCachePurge extends \Controller_Admin
{

	public function before()
	{
		if ( ! \Auth::has_access('maccess.admin'))
		{
			\Response::redirect('admin');
		}

		parent::before();

		$this->_views['controller_title'] = 'Nginx Cache Purge';
	}

	function structure()
	{
		return [
			'open' => [
				'type' => 'open',
			],
			'fu.plugins.nginx_cache_purge.urls' => [
				'type' => 'textarea',
				'preferences' => true,
				'label' => __('Cache cleaning URLs'),
				'help' => __('Insert the URLs that Nginx Cache Purge will have to contact and their eventual Basic Auth passwords. Make sure you "allow" only the IP from this server on the Nginx Cache Purge configuration block. The following is the format:') . 
				'<pre style="margin-top:8px">http://0-cdn-archive.yourdomain.org/purge/:username1:yourpass
				http://1-cdn-archive.yourdomain.org/purge/
				http://2-cdn-archive.yourdomain.org/purge/:username2:password</pre>',
				'class' => 'span8',
				'validation' => 'trim'
			],
			'separator-2' => [
				'type' => 'separator-short'
			],
			'submit' => [
				'type' => 'submit',
				'class' => 'btn-primary',
				'value' => __('Submit')
			],
			'close' => [
				'type' => 'close'
			],
		];
	}

	function actionManage()
	{
		$this->_views['method_title'] = 'Manage';

		$data['form'] = $this->structure();

		\Preferences::submit_auto($data['form']);

		// create a form
		$this->_views["main_content_view"] = \View::forge("admin/form_creator", $data);
		return \Response::forge(\View::forge("admin/default", $this->_views));
	}
}