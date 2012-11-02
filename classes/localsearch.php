<?php

namespace Yolp;

class LocalSearch
{
	/**
	 * Forge
	 *
	 * @param   array   $options
	 * @return  LocalSearch
	 */
	public static function forge(array $options = array())
	{
		return new static($options);
	}

	/**
	 * @var  Request
	 */
	protected $request = null;

	protected static $output_params = array('xml', 'json');

	public function __construct(array $options)
	{
		$this->request = Request::forge('local_search', $options);
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