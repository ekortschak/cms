<?php
/* ***********************************************************
// INFO
// ***********************************************************
Just "save as" ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("user/mail.php");

$mel = new mail($subject);
$mel->read($tpl);
$mel->setSubject($subject);
$mel->setFrom($from, $replyTo);
$mel->addRecipients($arr);
$mel->addRecipient($adress);
$mel->addMsg($text);

$mel->send("view | test | send");
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class mail extends tpl {
	private $tpl;
	private $rec = array();

function __construct($subject = "Info") {
	parent::__construct();

	$this->set("version", phpversion());
	$this->set("subject", $subject);
	$this->set("from", MAILMASTER);
	$this->set("replyto", NOREPLY);

	$this->read("design/templates/user/mail.std.tpl");
}

// ***********************************************************
// handling mail addresses
// ***********************************************************
public function setSubject($text) {
	$this->set("subject", $text);
}

public function setFrom($adr, $replyto = NV) {
	if ($replyto == NV) $replyto = $adr;

	$this->set("from",    $this->decode($adr));
	$this->set("replyto", $this->decode($replyto));
}

private function decode($adr) {
	if ($adr == "MAILTESTER") return MAILTESTER;
	if ($adr == "MAILMASTER") return MAILMASTER;
	return $adr;
}

// ***********************************************************
public function addRecipients($recipients ) {
	foreach ($recipients as $rec) {
		$this->addRecipient($rec);
	}
}
public function addRecipient($adr) {
	$tmp = explode(",", $adr);
	if (count($tmp) > 1) {
		$this->addRecipients($tmp);
		return;
	}
	$adr = trim($adr); if (! $adr) return;
	$this->rec[$adr] = $this->decode($adr);
}

// ***********************************************************
// handling messages
// ***********************************************************
public function setMsg($msg) {
	$this->setSec("message", $msg);
}
public function addMsg($msg) {
	$old = $this->getSec("message"); $old = trim($old); if ($old) $old.= "\n";
	$xxx = $this->setSec("message", $old.$msg);
}
public function addSep($msg) {
	$this->addMsg(str_repeat("*", 50));
	$this->addMsg($msg);
}

// ***********************************************************
// output
// ***********************************************************
public function send($mode = MAILMODE) {
	$this->merge($this->vls);

	if (IS_LOCAL) {
		MSG::now("mail.force preview");
		$mode = "preview";
	}
	$rec = implode(", ", $this->rec);

	switch ($mode) {
		case "send": return $this->mail($rec);
		case "test": return $this->test($rec);
		case "none": return "";
	}
	return $this->preview();
}

// ***********************************************************
private function preview() {
	$arr = array_slice($this->rec, 0, 4);
	$this->set("recipients", implode("; ", $arr));
	$this->set("count", count($this->rec));
	$this->show("preview");
	return true;
}

// ***********************************************************
public function test($rec = "nobody@home.at") {
	$hed = $this->getSection("header");
	$this->addSep("Recipient(s): <green>$rec</green>");
	$this->addSep("Headers: $hed");
	return $this->mail(MAILTESTER);
}

// ***********************************************************
private function mail($rec) {
	$hed = $this->getSection("header");  $sbj = $this->get("subject");
	$msg = $this->getSection("message"); $frm = $this->get("from");

	if (! $frm) return MSG::add("mail.no sender");
	if (! $rec) return MSG::add("mail.no recipients");
	if (! $sbj) return MSG::add("mail.no subject");
	if (! $msg) return MSG::add("mail.no message");

	if (! mail($rec, $sbj, "<pre>$msg</pre>", $hed)) {
		return MSG::add("mail.failed");
	}
	return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>