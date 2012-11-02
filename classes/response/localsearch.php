<?php

namespace Yolp;

class Response_LocalSearch extends \Response
{

	public function pins()
	{
		$body = $this->body();
		if (isset($body['Feature']))
		{
			$pins = array();
			foreach ($body['Feature'] as $key => $value)
			{
				$pins = array_merge($this->pin($key+1, $value), $pins);
			}
			return $pins;
		}
		return array();
	}

	public function pin($mark = '', $feature = null)
	{
		is_null($feature) and $body = $this->body() and $feature = $body['Feature'];
		$coordinates = explode(',', $feature['Geometry']['Coordinates']);
		return array("pin{$mark}" => "{$coordinates[1]},{$coordinates[0]}");
	}
}