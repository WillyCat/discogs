<?php

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

?>
