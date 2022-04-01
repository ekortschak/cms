<?php
/* ***********************************************************
// INFO
// ***********************************************************
- contains methods for fs objects

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/FSO.php");

*/

#FSO::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class FSO {
	private static $fext = false;
	private static $sort = "asc";
	private static $cnt;

public static function init() {
}

// ***********************************************************
// reducing paths to "local" paths
// ***********************************************************
public static function clearRoot($fso) { // default: $mode = inc
	$arr = APP::getFBK();

	foreach ($arr as $dir) {
		$out = STR::after($fso, $dir); if ($out !== false) return $out;
	}
	return $fso;
}

// ***********************************************************
// path commands
// ***********************************************************
public static function join() {
	$arr = func_get_args();
	$out = implode(DIR_SEP, $arr);
	return self::norm($out, false);
}

public static function norm($fso, $trail = true) { // $fso => dir or file
    $sep = DIR_SEP; if (self::isUrl($fso)) return $fso;

	$fso = rtrim($fso, $sep);
	$fso = str_replace("..", ".", $fso);
	$fso = str_replace("$sep.", $sep, $fso);
	$fso = preg_replace("~($sep+)~", $sep, $fso);

	if (is_dir($fso) && $trail) $fso.= $sep;
	return $fso;
}

public static function mySep($fso) {
	return strtr($fso, DIRECTORY_SEPARATOR, "/");
}

public static function isUrl($fso) {
	if (STR::contains($fso, "://")) return true;
	if (STR::contains($fso, "?")) return true;
	if (STR::contains($fso, "script:")) return true;
	return false;
}

// ***********************************************************
public static function force($dir, $mod = 0755) {
	$dir = self::norm($dir, false);
#	$dir = STR::pathify($dir);

	if (is_dir($dir)) return $dir;
	if (strlen($dir) < 5) return false;

	$erg = mkdir($dir, $mod, true); // includes chmod
	$xxx = self::permit($dir, $mod);

	return ($erg) ? $dir : false;
}

public static function hasXs($fso, $tell = true) {
	$out = is_writable($fso); if ($out) return $out;
	if ($tell) MSG::now("file.denied", $fso);
	return false;
}

protected static function permit($fso, $mod = 0775) {
	if (! IS_LOCAL) return;

	chown($fso, WWW_USER);
	chgrp($fso, WWW_USER);
	chmod($fso, $mod);
}

// ***********************************************************
// working on directories
// ***********************************************************
public static function copyDir($src, $dst) {
	$fso = self::fTree($src); if (! $fso) return;
	$dir = self::join($dst, basename($src));
	$dst = self::force($dir);
	$cnt = 0; krsort($fso);

	foreach ($fso as $fil => $nam) {
		$new = STR::after($fil, $src);
		$new = self::join($dst, $new);
		$cnt+= self::copy($fil, $new);
	}
	return $cnt;
}

// ***********************************************************
public static function mvDir($src, $dst) {
	$arr = self::fTree($src); if (! $arr) return;
	krsort($arr);

	foreach ($arr as $fso => $nam) {
		$new = STR::after($fso, $src.DIR_SEP);
		$new = self::join($dst, $new);
		$xxx = self::force(dirname($new));
		$erg = self::move($fso, $new); if (! $erg) return;
	}
	self::rmdir($src);
}

// ***********************************************************
public static function rmDir($src) {
	$fso = self::fdTree($src); krsort($fso);

	foreach ($fso as $obj => $nam) {
		if (is_file($obj)) self::kill($obj);
		if (is_dir($obj))  rmdir($obj);
	}
	rmdir($src);
	return 1;
}

// ***********************************************************
// methods for menus
// ***********************************************************
public static function parents($dir = "CURDIR", $min = APP_DIR) {
	if ($dir == "CURDIR") $dir = PFS::getLoc();
	if (  is_file($dir))  $dir = dirname($dir);
	if (! is_dir($dir))   $dir = APP::dir($dir);
	if (! is_dir($dir))	  return array();

	$out[] = $dir;

	while ($dir = dirname($dir)) {
		if ($dir < $min) break; // no access outside app path
		$out[] = $dir;
	}
	sort($out);
	return $out;
}

public static function getPrev($dir) {
	$par = dirname($dir);
	$arr = self::folders($par);
	$prv = $par;

	foreach ($arr as $key => $val) {
		if (STR::contains($key, $dir)) return $prv;
		$prv = $key;
	}
	return $dir;
}

// ***********************************************************
// dirs and files
// ***********************************************************
public static function rename($old, $new) {
	switch (is_dir($old)) {
		case true: return (bool) self::mvDir($old, $new); break;
		default:   return (bool) self::move($old, $new);
	}
}

// ***********************************************************
// files
// ***********************************************************
public static function fdTree($dir, $ptn = "*") {
 // list all files and dirs in $dir
	return self::ftree($dir, $ptn, false);
}
public static function fTree($dir, $ptn = "*", $filesOnly = true) {
 // default: list all files in $dir recursively
	$drs = self::tree($dir, false); // including hidden fso
	$out = self::files("$dir/$ptn", false);

	foreach ($drs as $dir => $nam) {
		if (is_link($dir)) continue;
		if (! $filesOnly) $out[$dir] = $nam;
		$out += self::files("$dir/$ptn", false);
	}
	ksort($out);
	return $out;
}

public static function files($pattern, $visOnly = true) {
 // list all files matching $pattern
	$ptn = self::norm($pattern); $out = array();
	$arr = glob($ptn); if (! $arr) return $out;

	foreach ($arr as $itm) {
		if (is_dir($itm)) continue;

		$chk = self::isHidden($itm); if ($chk) if ($visOnly) continue;
		$out[$itm] = basename($itm);
	}
	return $out;
}

// ***********************************************************
public static function backup($file) {
	if (! is_file($file)) return;
	$dst = APP::tempDir("backup", basename($file));
	self::copy($file, $dst);
}

public static function copy($src, $dst) { // copy a file
	$src = APP::file($src);
	$dir = self::force(dirname($dst)); copy($src, $dst);
	$xxx = self::permit($dst); if (is_file($dst)) return true;

	return ERR::assist("file", "no.write", $dst);
}

public static function move($old, $new) { // rename a file
	if (! is_file($old)) return false; rename($old, $new);
	if (  is_file($new)) return true;
	return ERR::assist("file", "no.copy", $new);
}

public static function kill($file) { // delete a file
	if (! is_file($file)) return false;
	return unlink($file);
}

// ***********************************************************
// folders
// ***********************************************************
public static function folderTitles($dir, $visOnly = true) {
	$arr = self::folders($dir, $visOnly); $out = array();

	foreach ($arr as $dir => $nam) {
		$out[$dir] = HTM::pgeTitle($dir);
	}
	return $out;
}
public static function folders($dir, $visOnly = true) {
 // list all folders in $dir
	$fso = $dir; if (! STR::contains($fso, "*")) $fso = self::join($dir, "*");
	$arr = glob($fso, GLOB_ONLYDIR); $out = array();

	foreach ($arr as $itm) {
		$chk = self::isHidden($itm); if ($chk) if ($visOnly) continue;
		$out[$itm] = basename($itm);
	}
	return $out;
}

// ***********************************************************
public static function tree($dir, $visOnly = true) {
 // list all subfolders of $dir
	if (is_link($dir)) return array();

	$dir = APP::dir($dir);                if (! $dir) return array();
	$arr = self::folders($dir, $visOnly); if (! $arr) return array();
	$out = $arr;

	foreach ($arr as $dir => $nam) {
		$lst = self::tree($dir, $visOnly); if (! $lst) continue;
		$out = array_merge($out, $lst);
	}
	ksort($out);
	return $out;
}

// ***********************************************************
// hiding fs objects
// ***********************************************************
public static function toggleVis($fso, $value = "toggle") {
	$par = dirname($fso);
	$itm = basename($fso);

	if (STR::begins($itm, HIDE)) $nam = trim($itm, HIDE);
	else $nam = HIDE.$itm;

	$new = self::join($par, $nam);
	rename($fso, $new);
	return $new;
}

public static function isHidden($fso) {
	return STR::contains($fso, DIR_SEP.HIDE);
}

// ***********************************************************
// extensions
// ***********************************************************
public static function ext($file, $norm = false) {
	$out = pathinfo($file, PATHINFO_EXTENSION); if ($norm)
	$out = STR::left($out);
	return $out;
}

public static function filter($files, $ext) {
	$ext = self::getExts($ext);
	$out = array(); if (! $files) return $out;

	foreach ($files as $fil => $nam) {
		if (! self::inExt($fil, $ext)) continue;
		$out[$fil] = $nam;
	}
	return $out;
}

public static function getExts($ext) {
	switch ($ext) {
		case "pics": $ext = "jpg,png,gif"; break;
	}
	$arr = STR::toArray($ext); $out = array();

	foreach ($arr as $itm) {
		$itm = STR::left($itm); if (! $itm) continue;
		$out[$itm] = $itm;
	}
	if (! $out) return array("*" => "*");
	return $out;
}

private static function inExt($fil, $arr) {
	$ext = self::ext($fil, true);
	$out = VEC::get($arr, "*" ); if ($out) return true;
	$out = VEC::get($arr, $ext); if ($out) return true;
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
