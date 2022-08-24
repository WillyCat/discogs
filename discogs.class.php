<?php

/*
Date        Version  Change
----------  -------  --------------------------------------------------
              1.0
2019-01-04    1.1    Added prototypes
                     No longer builds url, uses tinyUrl class to do so
2022-08-24    1.2    Split code, 1 file per class
*/

class discogs
{
	private $json;
	private $queryArray;
	protected $urlObject;
	private $url;

	public function
	__construct()
	{
		$this->urlObject = new tinyUrl('https://api.discogs.com');
		$this->queryArray = [ ];
	}

	protected function
	addParm ($name, $value)
	{
		$this -> queryArray[$name] = $value;
	}

	protected function
	query (bool $useauth = false): void
	{
		if ($useauth)
			$this->addParm ( 'token' , 'ADGlxSIfGRJkstFhoFDROWlgXiPWaQNgfOroeHOK');
		$this -> urlObject -> setQuery ($this -> queryArray);
		$this -> url = $this -> urlObject -> getUrl();

		$user_agent = 'FooBarApp/3.0';

		$r = new tinyHttp($this->url);
/*
$r->setHeader ('Accept', 'application/vnd.discogs.v2.plaintext+json');
$r->setHeader ('Host', 'api.discogs.com');
*/

		$r->setConfig([
		    'follow_redirects'        => true
				]);
		$r->setHeader([
			'User-Agent' => $user_agent
				]);

		$response = $r->send();

		$status = $response->getStatus();
		if ($status != 200)
			throw new Exception ('HTTP code ' . $status);

		$this -> json = $response->getBody();
	}

	public function
	getUrl(): string
	{
		return $this -> url;
	}

	public function
	getJson(): string
	{
		return $this -> json;
	}
}

?>
