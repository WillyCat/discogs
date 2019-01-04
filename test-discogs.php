<?php
require_once '/home/fhou732/classes/tinyHttp.class.php';
require_once 'discogs.class.php';

$id = '5017';
$d = new discogs_artist ($id);
echo 'URL: ' . $d -> getUrl() . "\n";
print_r ($d -> getProfile() );

echo "-------------------------------------------\n";

$q = 'Billy';
$d = new discogs_search ($q);
echo 'URL: ' . $d -> getUrl() . "\n";
print_r ($d -> getProfile() );

echo "-------------------------------------------\n";

?>
