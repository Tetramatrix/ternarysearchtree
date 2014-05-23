<?php
/***************************************************************
*
*  (c) 2010-2012 Chi Hoang (info@chihoang.de)
*  All rights reserved
*  
***************************************************************/

require_once ( "TernaryTree.php" );

$tree = new TernaryTree ( );
$tree->Insert ( "ANTEEHEM");
$tree->Insert ( "ANTEE");
$tree->Insert ( "ANTARES");
$tree->Insert ( "ANTEC");
$tree->Insert ( "ANTI");
$tree->Insert ( "TEARE");
$tree->Insert ( "Mario Circuit" );
$tree->Insert ( "Mario Circuit Builder" );
$tree->Insert ( "Marioc" );
$tree->Insert ( "Marioo" );

$tree->Search ( "ANTEEHEM" );
$tree->Search ( "Mario Circuit" );


?>