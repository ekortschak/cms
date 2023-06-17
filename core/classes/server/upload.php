<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for uploading files
* max upload files = 10

// ***********************************************************
// HOW TO USE
// ***********************************************************
$upl = new upload();
$upl->setOverwrite(true | false);
$upl->moveAllFiles($destination);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class upload {
	private $overwrite = true;
	private $maxfiles = 1;          // number of concurrent uploads
	private $maxsize = 1500 * 1000; // max size of files to upload
	private $minsize =   10 * 1000; // min for max file size
	private $ftypes = "*";          // file type filter

function __construct() {}

// ***********************************************************
public function setOverwrite($value = true) {
	$this->overwrite = (bool) $value;
}
public function setMaxFiles($value = 1) {
	$this->maxfiles = CHK::range($value, 1, 25);
}
public function setMaxSize($value = 1500000) {
	$this->maxfiles = CHK::range($value, $this->minsize, $this->maxsize);
}

// ***********************************************************
// handle uploaded files
// ***********************************************************
public function getFiles($qid = "fload") {
	$fls = array();
	$upl = VEC::get($_FILES, $qid); if (! $upl) return $fls;
	$anz = CHK::max($this->maxfiles, count($upl["name"]));

	for ($i = 0; $i < $anz; $i++) {
		$fil = $upl["name"][$i]; if (! $fil) continue;
		$inf = pathinfo($fil);

		$fls[$i] = array(
			"name" => $fil,
			"type" => $upl["type"][$i],
			"size" => $upl["size"][$i],
			"tfil" => $upl["tmp_name"][$i],
			"base" => $inf["filename"],
			"fext" => $inf["extension"],
			"enum" => $upl["error"][$i],
			"etxt" => $this->chkError($upl["error"][$i]),
		);
	}
	return $fls;
}

// ***********************************************************
// move files to destination
// ***********************************************************
public function moveAllFiles($dest) {
	$fls = $this->getFiles();
	return $this->moveFiles($fls, $dest);
}

public function moveFiles($files, $dest) {
	$cnt = $sux = 0; if (! $files) return;
	foreach ($files as $itm) {
		$cnt++;
		if ($itm["enum"]) {
			ERR::msg($itm["etxt"]); continue;
		}
		$sux+= $this->moveFile($itm["tfil"], $dest, $itm["name"]);
	}
	MSG::now("upl.copied", "$sux / $cnt");
}

public function moveFile($file, $dest, $fname) {
	if (! is_file($file)) return false;
	if (  is_file($dest)) if ($this->overwrite) FSO::kill($dest);
	if (  is_file($dest))
	return ERR::assist("net", "upl.exists", $file);

 // copy temp file to destination
	$fname = basename($fname);

	if (! copy($file, FSO::join($dest, $fname))) {
		return ERR::msg("upl.not copied", "$fname => $dest<br>$file");
	}
	return FSO::kill($file);
}

// ***********************************************************
// upload errors
// ***********************************************************
private function chkError($err) {
	if (! $err) return "";

	switch ($err) {
		case UPLOAD_ERR_INI_SIZE:	return "upl.exceeds ini"; break;
		case UPLOAD_ERR_FORM_SIZE:	return "upl.exceeds max"; break;
		case UPLOAD_ERR_PARTIAL: 	return "upl.incomplete";  break;
		case UPLOAD_ERR_NO_FILE:	return "upl.missing";     break;
		case UPLOAD_ERR_NO_TMP_DIR:	return "upl.temp dir";    break;
		case UPLOAD_ERR_CANT_WRITE:	return "upl.read only";   break;
	}
	return "upl.error";
}
// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
