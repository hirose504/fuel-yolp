<?php

namespace Yolp;

class StaticMap
{
	/**
	 * Forge
	 *
	 * @param   array   $options
	 * @return  StaticMap
	 */
	public static function forge(array $options = array())
	{
		return new static($options);
	}

	/**
	 * @var  Request
	 */
	protected $request = null;

	protected static $output_params = array('png', 'png32', 'gif', 'jpg', 'jpeg', 'xml');

	public function __construct(array $options)
	{
		$this->request = Request::forge('static_map', $options);
	}

	public static function image(array $params, array $options = array(), $output = 'png')
	{
		in_array($output, static::$output_params) or $output = 'png';
		return static::forge($options)->execute($params, $output)->response();
	}

	public static function xml(array $params, array $options = array())
	{
		return static::forge($options)->execute($params, 'xml')->response();
	}

	public function execute(array $params, $output = 'xml')
	{
		in_array($output, static::$output_params) or $output = 'xml';
		return $this->request->set_mime_type($output)->execute(array_merge(compact('output'), $params));
	}
}