<?php

namespace Yolp;

class Response_StaticMap extends \Response
{

	public function coordinates()
	{
		$body = $this->body();
		return $body['Result']['Coordinates'];
	}

	public function bbox()
	{
		$body = $this->body();
		return $body['Result']['Coordinate-DL']['Coordinates'].','.$body['Result']['Coordinate-UR']['Coordinates'];
	}
}