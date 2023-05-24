<?php
/* ***********************************************************
// INFO
// ***********************************************************
Implements basic functions for all classes

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("objects.php");

$obj = new obj();
$obj->set($key, $value);    // set variables
$obj->merge($arr);          // merge variables

$var = $obj->get($key, $default);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class objects {
	protected $oid = false;
	protected $vls = array(); // array of string values

function __construct() {}

// ***********************************************************
// handling variables
// ***********************************************************
public function merge($arr, $pfx = false) { // requires assoc array
	if (! $arr) return;
	if (! is_array($arr)) return;
    if ($arr == array_values($arr)) return; // no assoc

	foreach($arr as $key => $val) {
		if ($pfx) $key = "$pfx.$key";
		$this->set($key, $val);
	}
}

// ***********************************************************
public function set($key, $val) {
    $key = STR::norm($key); if (! $key) return false;
# TODO: why suddenly => test with gim - Schöpfer
#    $val = trim($val);

    if ($val === NV) {
		unset($this->vls[$key]);
		return false;
	}
	$this->vls[$key] = $val;
	return $val;
}

public function drop($sec, $key = "") { // drop values
	$chk = STR::trim("$sec.$key", ".");

	foreach ($this->vls as $key => $val) {
		if (STR::begins($key, $chk)) unset($this->vls[$key]);
	}
}

public function dup($new, $old) { // copy value to another key
	$val = $this->get($old);
	return $this->set($new, $val);
}

public function setIf($key, $default) { // preserve existing values
	$val = $this->get($key, $default);
	return $this->set($key, $val);
}

// ***********************************************************
public function get($key, $default = "") {
    $key = STR::norm($key);
	$out = VEC::get($this->vls, $key, NV);

	if ($out === NV) return $default;
	return $out;
}

// ***********************************************************
public function lng($key, $default = false) {
	$lng = CUR_LANG; $gen = GEN_LANG;
	$try = "$key.$lng";	$out = $this->get($try, NV); if ($out !== NV) return $out;
	$try = "$lng.$key";	$out = $this->get($try, NV); if ($out !== NV) return $out;
	$try = "$key.$gen";	$out = $this->get($try, NV); if ($out !== NV) return $out;
	$try = "$gen.$key";	$out = $this->get($try, NV); if ($out !== NV) return $out;
	return $this->get($key, $default);
}

// ***********************************************************
public function getKeys($pfx = "") {
	$arr = VEC::match($this->vls, $pfx);
	return VEC::keys($arr);
}

public function getValues($pfx = "") {
	return VEC::match($this->vls, $pfx);
}

public function setValues($sec, $arr) {
	foreach ($arr as $key => $val) {
		$key = "$sec.$key"; unset($this->vls[$key]);
		$this->set($key, $val);
	}
}

// ***********************************************************
public function isKey($key) {
	$out = VEC::get($this->vls, $key, NV);
	return ($out !== NV);
}

// ***********************************************************
// OID shortcuts
// ***********************************************************
public function register($oid = NV, $sfx = "*") {
	$this->oid = OID::register($oid, $sfx);
	$this->set("oid", $this->oid);
}

public function forget() {
	OID::forget($this->oid);
}

// ***********************************************************
// replacing vars in tpl-strings
// ***********************************************************
public function insVars($out) {
	$arr = STR::find($out, "<!VAR:", "!>");

	foreach ($arr as $key) {
		$val = $this->get($key, false); if (is_array($val))
		$val = "Array";
        $out = str_ireplace("<!VAR:$key!>", $val, $out);
    }
    return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
