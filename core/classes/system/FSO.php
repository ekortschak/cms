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
// path commands
// ***********************************************************
public static function join() {
	$out = implode(DIR_SEP, func_get_args());
	return FSO::norm($out);
}

public static function norm($fso) { // $fso => dir or file
	if (! $fso) return "";
    if (FSO::isUrl($fso)) return $fso;

    $sep = DIR_SEP;
	$fso = strtr($fso, DIRECTORY_SEPARATOR, $sep);
	$fso = rtrim($fso, $sep);

#	$fso = STR::replace($fso, "..", ".");
#	$fso = STR::replace($fso, "$sep.", $sep);
	$fso = preg_replace("~($sep+)~", $sep, $fso);
	return $fso;
}

public static function trim($fso) { // $fso => dir or file
	return STR::trim($fso, DIR_SEP);
}

public static function level($fso) {
	return STR::count($fso, DIR_SEP) + 1;
}

// ***********************************************************
public static function force($dir, $mod = 0775) {
	$dir = FSO::norm($dir); if (is_dir($dir)) return $dir;
	$chk = FSO::trim($dir); if (strlen($chk) < 1) return false;

	$erg = mkdir($dir, $mod, true); // includes chmod
	FSO::permit($dir, $mod);

	return ($erg) ? $dir : false;
}

public static function rename($old, $new) {
	if ($old == $new) return;

	if (is_dir($old))
	return (bool) FSO::mvDir($old, $new);
	return (bool) FSO::move ($old, $new);
}

// ***********************************************************
// file permissions
// ***********************************************************
public static function hasXs($fso, $tell = true) {
	return true;

// TODO
	if (is_writable($fso)) return true;
	if ($tell) MSG::now("file.denied", $fso);
	return false;
}

public static function permit($fso, $mod = 0775) {
	if (! IS_LOCAL) return;
// TODO: not setting correct permissions

	@chown($fso, WWW_USER);
	@chgrp($fso, WWW_USER);
	@chmod($fso, $mod);
}

// ***********************************************************
// folders
// ***********************************************************
public static function folders($dir = APP_DIR, $visOnly = true) {
	$out = array();

	if (! is_dir($dir)) $dir = FSO::findDir($dir);
	if (! is_dir($dir)) return $out;

	$hdl = opendir($dir); if (! $hdl) return $out;

	while (false !== ($itm = readdir($hdl))) {
		if (STR::begins($itm, "." )) continue; if ($visOnly)
		if (STR::begins($itm, HIDE)) continue;

		$ful = FSO::join($dir, $itm); if (is_file($ful)) continue;
		$out[$ful] = $itm;
	}
	closedir($hdl);
	return VEC::sort($out, "ksort");
}

public static function findDir($dir) {
	if (STR::misses($dir, "*")) return $dir;

	$par = dirname($dir);
	$fnd = STR::after(basename($dir), "*");
	$arr = glob("$par/*", GLOB_ONLYDIR);

	foreach ($arr as $itm) {
		if (STR::ends($itm, $fnd)) return $itm;
	}
	return $dir;
}

// ***********************************************************
// working on folders
// ***********************************************************
public static function copyDir($src, $dst) {
	$fso = FSO::fTree($src); if (! $fso) return; $cnt = 0;
	$xxx = FSO::force($dst);

	foreach ($fso as $fil => $nam) {
		$new = STR::after($fil, $src);
		$new = FSO::join($dst, $new);
		$cnt+= FSO::copy($fil, $new);
	}
	return $cnt;
}

// ***********************************************************
public static function mvDir($src, $dst) {
	$arr = FSO::fTree($src); if (! $arr) return false;

	foreach ($arr as $fso => $nam) {
		$new = STR::after($fso, $src.DIR_SEP);
		$new = FSO::join($dst, $new);
		$xxx = FSO::force(dirname($new));
		$erg = FSO::move($fso, $new); if (! $erg) return false;
	}
	return FSO::rmdir($src);
}

// ***********************************************************
public static function rmDir($src) {
	$arr = FSO::fdTree($src);
	$arr = VEC::sort($arr, "krsort"); // subdirs first

	foreach ($arr as $fso => $nam) {
		if (is_dir($fso)) rmdir($fso); else
		if (is_file($fso)) FSO::kill($fso);
	}
	return rmdir($src);
}

// ***********************************************************
// files
// ***********************************************************
public static function files($dir, $pattern = "*") {
 // collect all files matching $pattern
	$ptn = FSO::join($dir, $pattern); $out = array();
	$ptn = FSO::norm($ptn);

	$arr = glob($ptn); if (! $arr) return $out;

	foreach ($arr as $itm) {
		if (is_dir($itm)) continue;
		$out[$itm] = basename($itm);
	}
	return VEC::sort($out, "ksort");
}

public static function rmFiles($dir) {
	$fls = FSO::files($dir);

	foreach ($fls as $fil => $nam) {
		FSO::kill($fil, "", 0);
	}
}

// ***********************************************************
// working on files
// ***********************************************************
public static function backup($file) {
	if (! is_file($file)) return;
	$dst = LOC::tempDir("edited");
	$dst = FSO::join($dst, basename($file));
	FSO::copy($file, $dst);
}

public static function copy($src, $dst) { // copy a file
	$src = APP::file($src); if (! is_file($src)) return false;
	$dir = FSO::force(dirname($dst));
	copy($src, $dst); if (is_file($dst)) return true;
	return ERR::assist("file", "no.write", $dst);
}

public static function move($old, $new) { // rename a file
	if (! is_file($old)) return false;
	$dir = FSO::force(dirname($new));
	rename($old, $new); if (is_file($new)) return true;
	return ERR::assist("file", "no.write", $new);
}

public static function kill($file) { // delete a file
	if (! is_file($file)) return false;
	return unlink($file);
}

// ***********************************************************
// tree listings
// ***********************************************************
public static function dtree($dir, $visOnly = true) {
 // list all subfolders of $dir, including symbolic links
	$dir = APP::dir($dir);                if (! $dir) return array();
	$arr = FSO::folders($dir, $visOnly); if (! $arr) return array();
	$out = $arr;

	foreach ($arr as $dir => $nam) {
		$lst = FSO::dtree($dir, $visOnly); if ($lst)
		$out = array_merge($out, $lst);
	}
	return VEC::sort($out);
}

public static function fTree($dir, $pattern = "*", $incDirs = false) {
 // list all files in $dir recursively, including hidden dirs
	$drs = FSO::dtree($dir, false);
	$out = FSO::files($dir, $pattern);

	foreach ($drs as $dir => $nam) {
		if ($incDirs) $out[$dir] = $nam;
		$lst = FSO::files($dir, $pattern); if ($lst)
		$out = array_merge($out, $lst);
	}
	return VEC::sort($out);
}

public static function fdTree($dir, $pattern = "*") {
	return FSO::ftree($dir, $pattern, true);
}

public function dropEmpty($dir) {
	$fls = FSO::dtree($dir);

	foreach ($fls as $dir => $nam) {
		$arr = FSO::files($dir); if (count($arr) > 0) continue;
		$xxx = FSO::rmDir($dir);
	}
}

// ***********************************************************
// methods for menus
// ***********************************************************
public static function parents($dir) {
	if (  is_file($dir)) $dir = dirname($dir);
	if (! is_dir ($dir)) $dir = APP::dir($dir);
	if (! is_dir ($dir)) return array();

	$dir = APP::relPath($dir);
	$out[] = $dir;

	while ($dir = dirname($dir)) {
		if ($dir == ".") break; // no access outside app path
		$out[] = $dir;
	}
	sort($out);
	return $out;
}

public static function getPrev($dir) {
	$par = dirname($dir);
	$arr = FSO::folders($par);
	$prv = $par;

	foreach ($arr as $key => $val) {
		if (STR::contains($key, $dir)) return $prv;
		$prv = $key;
	}
	return $dir;
}

// ***********************************************************
// hiding fs objects
// ***********************************************************
public static function toggleVis($fso, $value = "toggle") {
	$par = dirname($fso);
	$itm = basename($fso);

	if (STR::begins($itm, HIDE)) $nam = STR::trim($itm, HIDE);
	else $nam = HIDE.$itm;

	$new = FSO::join($par, $nam);
	rename($fso, $new);
	return $new;
}

public static function isHidden($fso) {
	return STR::contains($fso, DIR_SEP.HIDE);
}

public static function isUrl($fso) {
	if (STR::contains($fso, "://")) return true;
	if (STR::contains($fso, "?")) return true;
	if (STR::contains($fso, "script:")) return true;
	return false;
}

// ***********************************************************
// extensions
// ***********************************************************
public static function ext($file, $norm = false) {
	$out = pathinfo($file, PATHINFO_EXTENSION); if ($norm)
	$out = STR::left($out);
	return $out;
}

public static function name($file) {
	$out = basename($file);
	return STR::before($out, ".");
}

public static function filter($files, $ext) {
	$ext = FSO::getExts($ext);
	$out = array(); if (! $files) return $out;

	foreach ($files as $fil => $nam) {
		if (! FSO::inExt($fil, $ext)) continue;
		$out[$fil] = $nam;
	}
	return $out;
}

private static function getExts($ext) {
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
	$ext = FSO::ext($fil, true);
	$out = VEC::get($arr, "*" ); if ($out) return true;
	$out = VEC::get($arr, $ext); if ($out) return true;
	return false;
}

public static function hash($file) {
#	return sha1_file($file);
	return md5_file($file);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
