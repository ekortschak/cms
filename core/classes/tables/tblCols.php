<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of table column features

// ***********************************************************
// HOW TO USE
// ***********************************************************
Used by class "tbl"
not intended for stand alone use
*/

incCls("other/items.php");
incCls("dbase/dbQuery.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tblCols extends items {
    private $flen = 15;
    private $mlen = 30;

function __construct() {}

// ***********************************************************
// handling properties
// ***********************************************************
public function setProp($item, $prop, $val) {
	$this->set($item, $prop, $val);

	switch ($prop) {
		case "dtype": case "type":
	        $aln = $this->align($val);
	        $this->setPropIf($item, "align", $aln);
			break;

	    case "vals":
	        if (is_array($val))
	        $this->setPropIf($item, "type", "com");
			break;

		case "flen":
			$len = CHK::range($val, 35, 1);
			$this->setPropIf($item, "flen", $len);
			break;

	    case "mlen":
			$rng = CHK::range($val, $this->mlen, 1);
			$this->setPropIf($item, "mlen", $rng);
			break;
	}
}

private function setPropIf($item, $prop, $val) {
	if (! $this->isItem($item)) return;
	$this->set($item, $prop, $val);
}

// ***********************************************************
// retrieving useful info
// ***********************************************************
public function sums() {
}

// ***********************************************************
// retrieving properties
// ***********************************************************
public function getInfo($item, $val = NV) {
	$out = $this->item($item); if (! $out) return false;

    $out["recid"] = $this->get($item, "recid", -1);
    $out["name"]  = $this->get($item, "name",  "C$item");
    $out["head"]  = $this->get($item, "head",  $out["name"]);
    $out["fname"] = $this->get($item, "fname", $out["name"]);
    $out["foot"]  = $this->get($item, "foot",  "");
    $out["dtype"] = $this->get($item, "dtype", "var");
    $out["align"] = $this->get($item, "align", "left");
    $out["flen"]  = $this->get($item, "flen",  $this->flen);
    $out["mlen"]  = $this->get($item, "mlen",  $this->mlen);
    $out["iskey"] = $this->get($item, "iskey", $out["dtype"] == "key");
    $out["ronly"] = $this->get($item, "ronly", false);
    $out["fnull"] = $this->get($item, "fnull", false);
    $out["hide"]  = $this->get($item, "hide",  $out["iskey"]);
	$out["ref"]   = $this->get($item, "deref", "");
    $out["mask"]  = $this->get($item, "mask",  "%s");
    $out["fnc"]   = $this->get($item, "fnc",   false);
    $out["fstd"]  = $this->get($item, "fstd",  $val);
    $out["vals"]  = $this->get($item, "vals",  $val);
    $out["raw"]   = $val;

	if ($out["ref"]) {
		$out["align"] = "left";
		$val = $this->getRef($val, $out["ref"]);
	}
	$val = $this->mask($val,  $out["mask"]);
	$val = $this->xform($val, $out["fnc"]);

    $out["type"]  = $out["dtype"];
    $out["value"] = $val;
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function mask($val, $msk) {
	if (! $val) return $val;
	if (is_object($val)) return $val;
	if (is_array($val)) return $val;
	if (STR::misses($msk, "%")) return $val;
	return sprintf($msk, $val, $val, $val);
}

private function xform($val, $fnc) {
	if (! $fnc) return $val;
	return $fnc($val);
}

private function getRef($val, $ref) {
	if (! $ref) return $val;

	$ref = STR::clear($ref, " ");
	$ref = str_replace("=>", ",", $ref);
	$ref = VEC::explode($ref, ",", 3);

	$dbq = new dbQuery(null, $ref[0]);
	$arr = $dbq->query("$ref[1]='$val'"); if (! $arr) return $val;
	return $arr[$ref[2]];
}

private function align($typ) {
	if ($typ == "int") return "right";
	if ($typ == "dbl") return "right";
	if ($typ == "dec") return "right";
	return "left";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
