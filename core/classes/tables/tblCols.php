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
    private $aln = array(); // links alignments to data types

    private $flen = 15;
    private $mlen = 30;

function __construct() {
    $this->aln = array( // contains all data types that won't align "left"
        "int" => "right", "dbl" => "right",
        "dec" => "right"
    );
}

// ***********************************************************
// handling properties
// ***********************************************************
public function setProp($item, $prop, $val) {
	parent::setProp($item, $prop, $val);

	switch ($prop) {
		case "dtype": case "type":
	        $aln = VEC::get($this->aln, $val, "left");
	        $this->itm["$item"]["align"] = $aln;
			break;

	    case "vals":
	        if (! is_array($val)) return;
	        $this->itm["$item"]["type"] = "com";
			break;

		case "flen":
			$this->itm["$item"]["flen"] = CHK::range($val, 35, 1);
			break;

	    case "mlen":
			$this->itm["$item"]["mlen"] = CHK::range($val, $this->mlen, 1);
			break;
	}
}

// ***********************************************************
// retrieving properties
// ***********************************************************
public function getColInfo($key, $val = NV) {
	$out = $this->getItem($key); if (! $out) return false;
	$val = $val;

    $out["recid"] = $this->getProp($key, "recid", -1);
    $out["name"]  = $this->getProp($key, "name",  "C$key");
    $out["head"]  = $this->getProp($key, "head",  $out["name"]);
    $out["fname"] = $this->getProp($key, "fname", $out["name"]);
    $out["foot"]  = $this->getProp($key, "foot",  "");
    $out["dtype"] = $this->getProp($key, "dtype", "var");
    $out["align"] = $this->getProp($key, "align", "left");
    $out["flen"]  = $this->getProp($key, "flen",  $this->flen);
    $out["mlen"]  = $this->getProp($key, "mlen",  $this->mlen);
    $out["iskey"] = $this->getProp($key, "iskey", $out["dtype"] == "key");
    $out["ronly"] = $this->getProp($key, "ronly", false);
    $out["fnull"] = $this->getProp($key, "fnull", false);
    $out["hide"]  = $this->getProp($key, "hide",  $out["iskey"]);
	$out["ref"]   = $this->getProp($key, "deref", "");
    $out["mask"]  = $this->getProp($key, "mask",  "%s");
    $out["fnc"]   = $this->getProp($key, "fnc",   false);
    $out["fstd"]  = $this->getProp($key, "fstd",  $val);
    $out["vals"]  = $this->getProp($key, "vals",  $val);
    $out["raw"]   = $val;

	if ($out["ref"]) {
		$out["align"] = "left";
		$val = $this->getRef($val, $out["ref"]);
	}
	$val = $this->getMasked($val, $out["mask"]);
	$val = $this->transform($val, $out["fnc"]);

    $out["type"]  = $out["dtype"];
    $out["value"] = $val;
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getMasked($val, $msk) {
	if (! $val) return $val;
	if (is_array($val)) return $val;
	if (! STR::contains($msk, "%")) return $val;
	return sprintf($msk, $val, $val, $val);
}

private function transform($val, $fnc) {
	if (! $fnc) return $val;
	return $fnc($val);
}

private function getRef($val, $ref) {
	if (! $ref) return $val;

	$ref = STR::clear($ref, " ");
	$ref = str_replace("=>", ",", $ref);
	$ref = VEC::explode($ref, ",", 3);

	$dbq = new dbQuery(NV, $ref[0]);
	$arr = $dbq->query("$ref[1]='$val'"); if (! $arr) return $val;
	return $arr[$ref[2]];
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
