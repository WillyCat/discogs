<?php

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
