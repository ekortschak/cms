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

	protected $timeout = 5;
	protected $errCnt = 0;
	protected $errMax = 5;

function __construct() {
	$this->read("config/ftp.ini");
}

public function read($inifile) {
	$this->set("inifile", $inifile);

	$ini = new ini($inifile);
	$prp = $ini->getValues(); $this->merge($prp);
	$prt = $ini->getSec("protect"); $this->set("protect", $prt);
}

// ***********************************************************
// ftp connection
// ***********************************************************
public function disconnect() {
	if ($this->con) ftp_close($this->con);
	$this->con = false;
}

public function connect() {
	if (! NET::isCon()) return ($this->con = false);
	if ($this->con) return $this->con;

	$srv = $this->get("ftp.fhost"); if (! $srv) return false;
	$usr = $this->get("ftp.fuser"); if (! $usr) return false;
	$pwd = $this->get("ftp.fpass"); if (! $pwd) return false;

	$con = @ftp_connect($srv);           if (! $con) return false;
	$erg = @ftp_login($con, $usr, $pwd); if (! $erg) return false;

	ftp_set_option($con, FTP_TIMEOUT_SEC, $this->timeout);
	ftp_raw($con, 'OPTS UTF8 ON');
	ftp_pasv($con, true);

	$this->con = $con;
	return $con;
}

public function fastCheck() {
    $con = @fsockopen("www.google.com", 80); fclose($con);
    return $con;
}

// ***********************************************************
public function isProtected($fso) {
	$prt = $this->get("protect"); if (! $prt) return false;
	return STR::contains($prt, "\n$fso");
}

public function test() {
	$con = $this->connect(); $this->disconnect(); if ($con) return true;
	$sts = ($con) ? BOOL_YES : BOOL_NO;

	$rst = ENV::getParm("ftp"); if ($rst == "reset") ENV::set("xfer", NV);

	$tpl = new tpl();
	$tpl->load("msgs/ftp.tpl");
	$tpl->set("inifile", $this->get("inifile"));
	$tpl->set("ftpstate", $sts);
	$tpl->show("test.rep");

	ENV::set("xfer", $con);
	return (bool) $con;
}

// ***********************************************************
// remote operations
// ***********************************************************
public function remote_mkDir($dir) {
	if (! $dir) return false;
	$erg = ftp_mkdir($this->con, $dir); if ($erg)
	$xxx = ftp_site($this->con, "CHMOD 0755 $dir");
	return (bool) $erg;
}
public function remote_rmdir($dir) {
	if (! $dir) return false;
	$erg = ftp_rmdir($this->con, $dir);
	return (bool) $erg;
}

// ***********************************************************
public function remote_rename($old, $new) {
	if (! $old) return false;
	if (! $new) return false;
	$erg = ftp_rename($this->con, $old, $new);
	return (bool) $erg;
}

// ***********************************************************
public function remote_del($file) {
	if (! $file) return false;
	$erg = ftp_delete($this->con, $file);
	return (bool) $erg;
}

// ***********************************************************
public function remote_put($src, $dst) {
	if ($this->isProtected($src)) return false;
	if ($this->errCnt >= $this->errMax) return false;
	if (! $dst) return false;

	if (ftp_put($this->con, $dst, $src, FTP_BINARY)) {
		$tim = date("YmdGis", filemtime($src)); // preserve timestamp
		ftp_raw( $this->con, "MFMT  $tim $dst");
		ftp_site($this->con, "CHMOD 0755 $dst");
		return true;
	}
	$this->errCnt++;
	return false;
}

// ***********************************************************
// write remote file to local dir
// ***********************************************************
public function save($src, $dst) {
	if ($this->isProtected($src)) return false;

	$erg = ftp_get( $this->con, $dst, $src, FTP_BINARY);
	$tim = ftp_mdtm($this->con, $src);

	if ($tim > 1) touch ($dst, $tim);
	return $erg;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

