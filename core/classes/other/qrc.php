<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to generate qr codes on the fly

depends on
* apt-get install libgd3
* apt-get install php-gd
* service apache2 restart

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/qrc.php");

QRC::show($text);
QRC::save($text, $file);
*/


include_once X_TOOLS."/qrcode/qrlib.php";

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class qrc {
	const ECC = "L"; // error correction capability
	const PIX =  2;  // pixel size
	const FRM =  0;  // frame size

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function show_kaputt($text) {
	QRcode::png($text);
}
public function show($text) {
	$fil = "./temp.png";
	$this->save($text, $fil);
	HTW::image($fil);
}

public function save($text, $file) {
	if (! $file) return;
	if (is_file($file)) return;
	QRcode::png($text, $file, QRC::ECC, QRC::PIX, QRC::FRM);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
