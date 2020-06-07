<?php

require_once(__DIR__ . '\..\vendor\autoload.php');

use cipher\multisubstitutioncipher\kennycode;

$c = new kennycode();
$c->setblock(5);

$ct = $c->encode('zielighekennyisinstukkengehaktdecacheligtopnoordtweeenvijftiggradenvijfentwintigminutenpuntzevenhonderdzevenentachtigoostnulviergradenzevendertigminutenpuntnegenhonderdvierentwintigsuccesmetzoeken');
$ct2 = $c->rowtocolumntransposition($ct, 3);
$ct3 = $c->decode($ct2);
if (strpos($ct3, '-') !== FALSE) echo "ALERT! fff found\n";

$c->setsep(' ');
echo strtoupper($c->formatoutput($ct3)), "\n";
$c->setsep('');

$pt3 = $c->encode($ct3);
$pt2 = $c->rowtocolumntransposition($pt3, strlen($pt3)/3);
$pt = $c->decode($pt2);
echo $pt, "\n";

?>
