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
	private $maxfiles = 10;
	private $maxsize = 1500 * 1000;
	private $ftypes = "*";

function __construct() {}

public function setOverwrite($value = true) {
	$this->overwrite = (bool) $value;
}
public function setMaxFiles($value= 10) {
	$this->maxfiles = CHK::range($value, 1, 25);
}
public function setMaxSize($value= 1500000) {
	$this->maxfiles = CHK::range($value, 0, $this->maxsize);
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
			"enum" => $upl["error"][$i],
			"etxt" => $this->chkError($upl["error"][$i]),
			"tfil" => $upl["tmp_name"][$i],
			"base" => $inf["filename"],
			"fext" => $inf["extension"]
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
	MSG::now("files.moved", "$sux / $cnt");
}

public function moveFile($file, $dest, $fname) {
 // check if source exists
	if (! is_file($file)) return false;
 // check if destination exists
	if (is_file($dest)) if ($this->overwrite) FSO::kill($dest);
	if (is_file($dest))
	return ERR::assist("net", "ftp.exists", $file);

 // copy temp file to destination
	$fname = basename($fname);

	if (! copy($file, FSO::join($dest, $fname))) {
		return ERR::msg("file.not copied", "$fname => $dest<br>$file");
	}
	return FSO::kill($file);
}

// ***********************************************************
// upload errors
// ***********************************************************
private function chkError($err) {
	if (! $err) return "";

	switch ($err) {
		case UPLOAD_ERR_INI_SIZE:	return "FILE.exceeds ini";	break;
		case UPLOAD_ERR_FORM_SIZE:	return "FILE.exceeds max";	break;
		case UPLOAD_ERR_PARTIAL: 	return "FILE.incomplete";	break;
		case UPLOAD_ERR_NO_FILE:	return "FILE.missing";		break;
		case UPLOAD_ERR_NO_TMP_DIR:	return "ERR.NO temp dir";	break;
		case UPLOAD_ERR_CANT_WRITE:	return "XS.read only";		break;
	}
	return "ERR.unknown";
}
// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
