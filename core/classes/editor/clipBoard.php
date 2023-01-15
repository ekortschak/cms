<?php
/* ***********************************************************
// INFO
// ***********************************************************


// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/clipBoard.php");

$clipBoard = new clipBoard();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class clipBoard {
	private $dir = "";

function __construct() {
	$dir = APP::tempDir("clipboard");
	$dir = FSO::force($dir);

	$this->dir = $dir;
}

public function getList() {
	return FSO::folders($this->dir);
}

// ***********************************************************
// methods
// ***********************************************************
public function exec($dir) {
	$chk = ENV::getPost("clip_act"); if (! $chk) return false;

	switch (STR::left($chk)) {
		case "cop": $this->copy($dir);  break; // copy to clipboard
		case "cut": $this->move($dir);  break; // move to clipboard
		case "pas": $this->paste($dir); break; // restore as menu item
		case "del": $this->drop();      break; // drop from clipboard
	}
	return true;
}

private function copy($src) {
	return FSO::copyDir($src, $this->dir);
}

private function move($src) {
	$dst = FSO::join($this->dir, basename($src));
	return FSO::mvDir($src, $dst);
}

private function paste($dst) {
	$src = ENV::getPost("clip");
	$dst = FSO::join($dst, basename($src));
	return FSO::mvDir($src, $dst);
}

private function drop() {
	$src = ENV::getPost("clip");
	return FSO::rmDir($src);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
