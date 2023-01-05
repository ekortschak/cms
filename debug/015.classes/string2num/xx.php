<?php

incCls("other/string2num.php");

function test($val) {
	$obj = new string2num();
	DBG::text($obj->conv($val), $val);
}

// ***********************************************************
HTW::tag("100er");
// ***********************************************************
test("hundert");
test("hunderteins");
test("hundertelf");
test("zweihundert");
test("zweihundertundfünf");
test("elfhundertelf");

// ***********************************************************
HTW::tag("1000er");
// ***********************************************************
test("tausend");
test("zweitausend");
test("zweitausendzwei");
test("zweitausendzweiundzwanzig");
test("elftausendzwei");

test("zweihundertundfünftausend");

// ***********************************************************
HTW::tag("100.000er");
// ***********************************************************
test("hunderttausend");
test("zweihunderttausend");
test("zweihundertundfünftausendsechshundert");
test("zweihundertundfünftausendsechshunderteinunddreissig");
test("zweihundertundfünftausendsechshundertvier");

// ***********************************************************
HTW::tag("Ordnungszahlen");
// ***********************************************************
test("zum ersten Mal");
test("im vierhundertachtzigsten Jahr");
test("am zehnten Tag des zweiten Monats");

// ***********************************************************
HTW::tag("Misc");
// ***********************************************************
test("Der Oberste der Tausendschaften.");
test("bis zu tausend Mann");
test("bis zu tausend.");
test("vieltausendmal");

test("abc sieben abc");
test("abc hunderttausend abc");
test("abc hundertelftausend abc");

test("siebzig mal sieben mal");
test("siebzigmal");

?>
