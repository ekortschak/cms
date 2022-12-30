<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended for tables fed by a csv file

*/

incCls("tables/htm_table.php");
incCls("files/csv.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class csv_table extends htm_table {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// handling data
// ***********************************************************
public function load($file, $sep = ";") {
	if (! is_file($file)) return;

	$csv = new csv($sep);
	$csv->read($file);

    $this->addCols($csv->getHeads());
    $this->addRows($csv->getData());
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
