<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for uploading files to server via ftp

// ***********************************************************
// HOW TO USE
// ***********************************************************
$ftp = new ftp();
$ftp->merge($prp); if (! $ftp->test()) return;

$ftp->connect();
$ftp->remote_mkdir($dir);
$ftp->remote_rmdir($dir);
$ftp->remote_put($src, $dst);
$ftp->remote_del($file);
$ftp->disconnect();

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ftp extends objects {
	protected $ini = "";
	protected $con = false;
	protected $lst = array();
	protected $prt = array(); // protected config files

function __construct() {
	$this->read("config/ftp.ini");
}

public function read($inifile) {
	$this->set("inifile", $inifile);

	$ini = new ini($inifile);
	$prp = $ini->getValues();
	$this->merge($prp);

	$prt = $ini->getValues("protect");
	$this->prt = array_keys($prt);
}

// ***********************************************************
// ftp connection
// ***********************************************************
public function disconnect() {
	if ($this->con) ftp_close($this->con);
	$this->con = false;
}
public function connect() {
	if ($this->con) return $this->con;

	$srv = $this->get("ftp.fhost"); if (! $srv) return false;
	$usr = $this->get("ftp.fuser"); if (! $usr) return false;
	$pwd = $this->get("ftp.fpass"); if (! $pwd) return false;

	$con = ftp_connect($srv);           if (! $con) return false;
	$erg = ftp_login($con, $usr, $pwd); if (! $erg) return false;
	$xxx = ftp_raw($con, 'OPTS UTF8 ON');
	$xxx = ftp_pasv($con, true);
	$xxx = ftp_set_option($con, FTP_TIMEOUT_SEC, 5);

	$this->con = $con;
	return $con;
}

// ***********************************************************
public function isProtected($fso) {
	foreach ($this->prt as $itm) {
		if (STR::begins($fso, $itm)) return true;
	}
	return false;
}

public function test() {
	$rst = ENV::getParm("ftp"); if ($rst == "reset") ENV::set("xfer", NV);
	$sts = ENV::get("xfer", NV);

	if ($sts == NV) {
		$con = $this->connect(); $this->disconnect();
		$sts = ($con) ? "OK" : "0";
	}
	$tpl = new tpl();
	$tpl->read("design/templates/msgs/ftp.tpl");
	$tpl->set("inifile", $this->get("inifile"));
	$tpl->set("status", $sts);
	$tpl->show("test.rep");

	ENV::set("xfer", $sts);
	return (bool) $sts;
}

// ***********************************************************
// remote operations
// ***********************************************************
public function remote_mkDir($dir) {
	$dst = $this->chkChars($dir); if (! $dst) return false;
	$erg = ftp_mkdir($this->con, $dst); if ($erg)
	$xxx = ftp_site($this->con, "CHMOD 0755 $dst");
	return (bool) $erg;
}
public function remote_rmdir($dir) {
	$erg = ftp_rmdir($this->con, $dir);
	return (bool) $erg;
}

// ***********************************************************
public function remote_rename($old, $new) {
	$dst = $this->chkChars($dir); if (! $dst) return false;
	$erg = ftp_rename($this->con, $old, $new);
	return (bool) $erg;
}

// ***********************************************************
public function remote_del($file) {
	$fil = $this->chkChars($file); if (! $fil) return false;
	$erg = ftp_delete($this->con, $fil);
	return (bool) $erg;
}
public function remote_put($src, $dst) {
	$dst = $this->chkChars($dst); if (! $dst) return false;
	$erg = ftp_put($this->con, $dst, $src, FTP_BINARY);

	if ($erg) { // preserve timestamp
		$tim = date("YmdGis", filemtime($src));
		ftp_raw( $this->con, "MFMT  $tim $dst");
		ftp_site($this->con, "CHMOD 0755 $dst");
		return true;
	}
	$src = FSO::clearRoot($src);
	MSG::now("ftp.xfer error", $src);
	return false;
}

// ***********************************************************
// write remote file to local dir
// ***********************************************************
public function save($src, $dst) {
	$tim = ftp_mdtm($this->con, $src); if ($tim < 1) return false;
	$erg = ftp_get( $this->con, $dst, $src, FTP_BINARY);
	touch ($dst, $tim);
	return $erg;
}

// ***********************************************************
// char issues
// ***********************************************************
public function chkChars($fso, $level = 1) {
	$lst = "[^A-Z_a-z0-9\/\.]";
	$out = preg_replace("~($lst+)~", "", $fso);

	if ($out == $fso) return $out;

	$this->rep["bad"][] = $fso;
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

