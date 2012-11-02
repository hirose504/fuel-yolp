<?php

namespace Yolp;

class Request extends \Request_Curl
{
	public static function _init()
	{
		\Config::load('yolp', true);
	}

	public function __construct($resource, array $options, $method = null)
	{
		$uri = \Config::get('yolp.uri');
		in_array($resource, array_keys($uri)) and $resource = $uri[$resource];
		isset($options['params']['appid']) or $options['params']['appid'] = \Config::get('yolp.appid');
		isset($options['params']['cid'])   or $options['params']['cid']   = \Config::get('yolp.cid');
		parent::__construct($resource, $options, $method);
	}

	public function execute(array $additional_params = array())
	{
		try
		{
			parent::execute($additional_params);
		}

		catch (\RequestStatusException $e)
		{
			throw new \FuelException($e->getMessage());
		}

		catch (\RequestException $e)
		{
			if (empty($this->params['appid']))
			{
				throw new \FuelException('Yahoo! JAPAN application ID is not set.');
			}
			else
			{
				throw new \FuelException($e->getMessage());
			}
		}

		return $this;
	}

	protected function get_resource_name()
	{
		$uri = \Config::get('yolp.uri');

		foreach ($uri as $k => $v)
		{
			if (strpos($this->resource, $v) !== false)
			{
				return $k;
			}
		}

		return false;
	}

	public function set_response($body, $status, $mime = null, $headers = array())
	{
		if ( ! $resource = $this->get_resource_name())
		{
			return parent::set_response($body, $status, $mime, $headers);
		}

		$class = '\\Response_'.\Inflector::camelize(strtolower($resource));

		if( ! class_exists($class, true))
		{
			return parent::set_response($body, $status, $mime, $headers);
		}

		if ($this->auto_format and array_key_exists($mime, static::$auto_detect_formats))
		{
			$body = \Format::forge($body, static::$auto_detect_formats[$mime])->to_array();
		}

		$this->response = $class::forge($body, $status, $headers);

		return $this->response;
	}
}