<?php
/* ***********************************************************
// INFO
// ***********************************************************
wrapper for search.php
* meant to facilitate different implementations of the search
* module according to app requirements

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/swrap.php");

$bbl = new swrap();
*/

incCls("search/search.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class swrap extends search {

function __construct() {
	parent::__construct();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
