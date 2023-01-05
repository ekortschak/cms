<?php

incCls("other/string2num.php");

function test($val, $chk = "~") {
	$obj = new string2num();
	$out = $obj->conv($val);

	if ($chk == "~") $chk = $val;
	if ($out == $chk) {
		DBG::text($val, $out);
	}
	else {
		$out = HTM::tag($out, "red");
		DBG::text($val, $out);
	}
}

// ***********************************************************
HTW::tag("100er");
// ***********************************************************
test("hundert", 100);
test("hunderteins", 101);
test("hundertelf", 111);
test("zweihundert", 200);
test("zweihundertundfünf", 205);
test("zweihundertundacht", 208);
test("elfhundertelf", "1.111");

// ***********************************************************
HTW::tag("1000er");
// ***********************************************************
test("tausend", "1.000");
test("zweitausend", "2.000");
test("zweitausendzwei", "2.002");
test("zweitausendzweiundzwanzig", "2.022");
test("elftausendzwei", "11.002");

test("zweihundertundfünftausend", "205.000");

// ***********************************************************
HTW::tag("100.000er");
// ***********************************************************
test("hunderttausend", "100.000");
test("zweihunderttausend", "200.000");
test("zweihundertundfünftausendsechshundert", "205.600");
test("zweihundertundfünftausendsechshunderteinunddreissig", "205.631");
test("zweihundertundfünftausendsechshundertvier", "205.604");

// ***********************************************************
HTW::tag("Ordnungszahlen");
// ***********************************************************
test("zum ersten Mal", "zum 1. Mal");
test("im vierhundertachtzigsten Jahr", "im 480. Jahr");
test("am zehnten Tag des zweiten Monats", "am 10. Tag des 2. Monats");

// ***********************************************************
HTW::tag("Acht");
// ***********************************************************
test("acht", 8);
test("in der Nacht");
test("Achtung");
test("habt Acht");
test("achte auf mich");
test("achtens", 8.);

// ***********************************************************
HTW::tag("Misc");
// ***********************************************************
test("Der Oberste der Tausendschaften");
test("mit tausend Mann", "mit 1.000 Mann");
test("bis zu tausend.", "bis zu 1.000.");

test("im Alter von fünfhundert Jahren", "im Alter von 500 Jahren");

test("vieltausendmal");
test("siebzig mal sieben mal", "70 mal 7 mal");
test("siebzigmal", "70mal");

?>
