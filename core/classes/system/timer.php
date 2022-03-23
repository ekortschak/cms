<?php
/* ***********************************************************
// INFO
// ***********************************************************
Timer functionality ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/timer.php");

$tim = new timer();
$tim->lapse($info);
$tim->total($info);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class timer {
	private $sTime = 0;
	private $cTime = 0;

function __construct() {
	$this->sTime = $this->cTime = microtime(true);
}

// ***********************************************************
public function total() { // get total runtime
	return self::doTime($this->sTime);
}
public function lapse() { // get elapsed time
	return self::doTime($this->cTime);
}

// ***********************************************************
private function doTime($ref) {
	$xxx = $this->cTime = microtime(true);
	return $this->cTime - $ref;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************

?>
