<?php

class discogs
{
	private $json;
	private $url;

	public function
	__construct($id)
	{
	}

	protected function
	query (string $url, bool $useauth = false): void
	{
		$this->url = 'https://api.discogs.com' . $url;
		if ($useauth)
			$this->url .= '&token=' . 'ADGlxSIfGRJkstFhoFDROWlgXiPWaQNgfOroeHOK';
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
		{
			throw new Exception ('HTTP code ' . $status);
		}

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
	__construct($q, $type = 'artist')
	{
		$this -> q = $q;
		$this -> query ('/database/search?q='. urlencode($q) . '&type=' . $type, true);

		$this -> profile = json_decode ($this -> getJson());
		if (!isset ($this->profile))
			throw new Exception ('Retrieval failure');
	}

	public function
	getProfile()
	{
		return $this -> profile;
	}
}

class discogs_artist extends discogs
{
	private $id;
	private $profile;

	public function
	__construct($id)
	{
		$this -> id = $id;
		$this -> query ('/artists/'. $id, false);

		$this -> profile = json_decode ($this -> getJson());
		if (!isset ($this->profile))
			throw new Exception ('Retrieval failure');
	}

	public function
	getProfile()
	{
		return $this -> profile;
	}
}

?>
