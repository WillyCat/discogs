<?php

/*
Date        Version  Change
----------  -------  --------------------------------------------------
              1.0
2019-01-04    1.1    Added prototypes
                     No longer builds url, uses tinyUrl class to do so
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

class discogs_search extends discogs
{
	private $q;
	private $profile;

	public function
	__construct(string $q, $type = 'artist')
	{
		parent::__construct();
		$this -> q = $q;
		$this -> urlObject -> setPath ('/database/search');
		$this -> addParm ('q' , $q );
		$this -> addParm ('type' , $type );
		$this -> query (true);

		$this -> profile = json_decode ($this -> getJson());
		if (!isset ($this->profile))
			throw new Exception ('Retrieval failure');
	}

	public function
	getProfile(): Object
	{
		return $this -> profile;
	}
}

class discogs_artist extends discogs
{
	private $id;
	private $profile;

	public function
	__construct(int $id)
	{
		parent::__construct();
		$this -> id = $id;
		$this -> urlObject -> setPath ('/artists/'. $id);
		$this -> query (false);

		$this -> profile = json_decode ($this -> getJson());
		if (!isset ($this->profile))
			throw new Exception ('Retrieval failure');
	}

	public function
	getProfile(): Object
	{
		return $this -> profile;
	}
}

?>
