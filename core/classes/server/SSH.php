<?php

class SSH {
    private $srv = "myserver.example.com";
    private $prt = 22;
    private $key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
    private $usr = "username";
    private $pub = "/home/username/.ssh/id_rsa.pub";
    private $prv = "/home/username/.ssh/id_rsa";
    private $pwd;
    private $con;

public function connect() {
	$this->con = ssh2_connect($this->srv, $this->prt);

	if (! $this->con)
	throw new Exception("Cannot connect to server");

	$key = ssh2_fingerprint($this->con, SSH2_FINGERPRINT_MD5 | SSH2_FINGERPRINT_HEX);

	if (strcmp($this->key, $key) !== 0)
	throw new Exception("Unable to verify server identity!");

	if (! ssh2_auth_pubkey_file($this->con, $this->usr, $this->pub, $this->prv, $this->pwd)) {
		throw new Exception("Autentication rejected by server");
	}
}

public function exec($cmd) {
	if (! $hdl = ssh2_exec($this->con, $cmd)) {
		throw new Exception("SSH command failed");
	}
	stream_set_blocking($hdl, true);
	$out = "";

	while ($buf = fread($hdl, 4096)) {
		$out .= $buf;
	}
	fclose($hdl);
	return $out;
}

public function disconnect() {
	$this->exec("echo \"EXITING\" && exit;");
	$this->con = null;
}

}
?>
