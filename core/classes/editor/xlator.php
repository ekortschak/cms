<?php
/* ***********************************************************
// INFO
// ***********************************************************
This class is designed to replace strings by their translated values.
* Translation is not automatic since it requires a paid service.
* Instead a string will be provided that is to be pasted into an online translator.
* The translation will then be pasted in a form
* from which the replacements will be effected.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/xlator.php");

$xlator = new xlator();
$htm = $dic->getTags($fil);
$htm = $dic->getRepText($rep);
$xxx = $dic->save($fil, $htm, $lang);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class xlator {
	private $tgs = array(); // tags that need to be translated
	private $php = array(); // code snips
	private $dic = array(); // text snips

	private $rep = "";      // text with place holders
	private $act = "";      // text to translate

function __construct() {
	$tgs = "php.h1.h2.h3.h4.h5.h6.p.li.dt.dd.div.td";
	$this->tgs = STR::toArray($tgs);
}

// ***********************************************************
// methods
// ***********************************************************
public function getTags($txt) { // passing file or text
	if (is_file($txt)) $txt = APP::read($txt);
	$this->dir = $this->php = array(); $out = "";

	$txt = $this->secure($txt);
	$txt = $this->cutBreaks($txt);
	$xxx = $this->recurse($txt);
	$rep = $txt;

	foreach ($this->dic as $key => $itm) {
		$rep = STR::replace($rep, $itm, "[$key]");
		$out.= "[$key] = $itm\n";
	}
	$out = $this->restore($out);
	$this->rep = $rep;

	return $out;
}

public function save($file, $text, $lang) {
	if (strlen($text) < 5) {
		return MSG::now("no.data");
	}
	return APP::write($file, $text);
}

// ***********************************************************
// replace text by translations - preserving php snips
// ***********************************************************
public function getRepText($txt) {
	$arr = STR::split($txt, "["); $lst = array();

	foreach ($arr as $key => $val) {
		$key = STR::between($val, "[", "]");
		$val = STR::after($val, "=");
		$lst[$key] = $this->cleanTags($val);
	}
	$out = $this->repKeys($this->rep, $lst);
	$out = $this->repKeys($out, $this->php);
	$out = $this->restore($out);
	return $out;
}

private function repKeys($out, $arr) {
	foreach ($arr as $key => $val) {
		if (! $key) continue;
		$out = STR::replace($out, "[$key]", $val);
	}
	return $out;
}

private function cleanTags($txt) {
	$out = $this->cleanTag($txt, "b");
	$out = $this->cleanTag($out, "u");
	$out = $this->cleanTag($out, "i");
	return $out;
}

private function cleanTag($txt, $tag) {
	$out = STR::replace($txt, "<$tag> ",  "<$tag>");
	$out = STR::replace($out, " </$tag>", "</$tag>");
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function recurse($txt) {
	foreach($this->tgs as $tag) {
		$arr = STR::find($txt, "<$tag>", "</$tag>"); if (! $arr) continue;

		foreach ($arr as $val) {
			$md5 = md5($val); if (! $val) continue;

			if ($tag == "php")
			$this->php[$md5] = $val; else
			$this->dic[$md5] = $val;

			$txt = STR::replace($txt, "<$tag>$val</$tag>", "<$tag>[$md5]</$tag>");
		}
	}
}

private function cutBreaks($txt) {
	$brk = '<hr class="pbr">';
	$txt = STR::clear($txt, "$brk\n\n");
	$txt = STR::clear($txt, "$brk\n");
	$txt = STR::clear($txt,  $brk);
	return $txt;
}

private function secure($txt) {
	$txt = STR::replace($txt, "\n", "§lf§");
	$txt = STR::replace($txt, "<?php ", "<php>");
	$txt = STR::replace($txt, " ?>", "</php>");
	return $txt;
}
private function restore($txt) {
	$txt = STR::replace($txt, "§lf§", "\n");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
