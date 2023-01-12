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
	parent::setProp($item, $prop, $val);

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
	if (parent::getProp($item, $prop, NV) !== NV) return;
	parent::setProp($item, $prop, $val);
}

// ***********************************************************
// retrieving useful info
// ***********************************************************
public function getCols() {
	return $this->getItems();
}

public function getSums() {
}

// ***********************************************************
// retrieving properties
// ***********************************************************
public function getInfo($item, $val = NV) {
	$out = $this->getItem($item); if (! $out) return false;

    $out["recid"] = parent::getProp($item, "recid", -1);
    $out["name"]  = parent::getProp($item, "name",  "C$item");
    $out["head"]  = parent::getProp($item, "head",  $out["name"]);
    $out["fname"] = parent::getProp($item, "fname", $out["name"]);
    $out["foot"]  = parent::getProp($item, "foot",  "");
    $out["dtype"] = parent::getProp($item, "dtype", "var");
    $out["align"] = parent::getProp($item, "align", "left");
    $out["flen"]  = parent::getProp($item, "flen",  $this->flen);
    $out["mlen"]  = parent::getProp($item, "mlen",  $this->mlen);
    $out["iskey"] = parent::getProp($item, "iskey", $out["dtype"] == "key");
    $out["ronly"] = parent::getProp($item, "ronly", false);
    $out["fnull"] = parent::getProp($item, "fnull", false);
    $out["hide"]  = parent::getProp($item, "hide",  $out["iskey"]);
	$out["ref"]   = parent::getProp($item, "deref", "");
    $out["mask"]  = parent::getProp($item, "mask",  "%s");
    $out["fnc"]   = parent::getProp($item, "fnc",   false);
    $out["fstd"]  = parent::getProp($item, "fstd",  $val);
    $out["vals"]  = parent::getProp($item, "vals",  $val);
    $out["raw"]   = $val;

	if ($out["ref"]) {
		$out["align"] = "left";
		$val = $this->getRef($val, $out["ref"]);
	}
	$val = $this->mask($val, $out["mask"]);
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
	if (is_array($val)) return $val;
	if (! STR::contains($msk, "%")) return $val;
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

	$dbq = new dbQuery(NV, $ref[0]);
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
