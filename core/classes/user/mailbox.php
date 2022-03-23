
// Verbindung herstellen
$server='{mail.domain.at:143}INBOX';
$adresse='vorname.nachname@domain.at';
$password='supergeheim';
$mbox = imap_open($server, $adresse, $password, OP_READONLY);


// mailbox auslesen
$no=1;
$arr = imap_headers($mbox);

for($i = 0; $i &lt; count($headers); ++$i) {
	echo "Header: ".$arr[$i]."&lt;br&gt;";
	echo "Body: ".imap_fetchbody($mbox, $i+1, 1)."&lt;br&gt;";
	echo "&lt;hr/&gt;";
}




<html>
<head> <title> Mail </title> </head>
<body bgcolor=D3D3D3>
<table> <tr> <td>
<?PHP

//$Host="(smtp.gmx.de: 110/pop3) INBOX"; // Host zu verbinden

$Host="{pop.1und1.de/pop3:110}INBOX"; // Host zu verbinden
$User="alias@domain.tld";
$Pass="leer";
$Aus=$User; // Mail zu senden

$ip = getenv("REMOTE_ADDR");

$count_bestellung_gesamt = 0;

$Mail=imap_open($Host,$User,$Pass) Or die ("Kann keine Verbindung:" . imap_last_error());

echo "<h1>Neue Mails</h1>\n";

$headers = imap_headers($MAIL);
print_r($headers);

$message_count = imap_num_msg($Mail);

echo "Anzahl Mails: ".$message_count."<BR>\n";

//Verbindung zu Mailbox
$m_mail = imap_open($Host,$User,$Pass) or die("ERROR: " . imap_last_error());

$m_gunixtp = array(2592000, 1209600, 604800, 259200, 86400, 21600, 3600);

//bis welchem Zeitpunkt die Mails gelesen werden sollen.
$m_gdmy = date('d-M-Y', time() - $m_gunixtp[$m_t]);

//suche nach ungelesenen Mails
//$m_search=imap_search ($m_mail, 'UNSEEN SINCE ' . $m_gdmy . '');

//gebe alle Mails aus 'ALL'
$m_search=imap_search ($m_mail, 'ALL ');


//If mailbox is empty......Display "No New Messages", else........ You got mail....oh joy
if($m_search < 1){
	$m_empty = "No New Messages";}
else {
	//sortiert das Array, neuste zuerst.
	rsort($m_search);


	// nur ungelesene ...
	foreach ($m_search as $what_ever) {

		//liefert die Kopfdaten
		$obj_thang = imap_headerinfo($m_mail, $what_ever);
		//print_r($obj_thang);

		//liest die Mail aus ...
		$part=imap_fetchbody($Mail,$what_ever,1);
		//print_r($part);  // => liefert den Mailinhalt...

		$part=imap_fetchbody($Mail,$what_ever,2);
		//print_r($part);  // => liefert die Anlagen

		$adress_from = str_replace("<", "&lt;", $obj_thang->fromaddress);
		$adress_from = str_replace(">", "&gt;", $adress_from);
		$adress_to = str_replace("<", "&lt;", $obj_thang->toaddress);
		$adress_to = str_replace(">", "&gt;", $adress_to);

		$mail_betreff = $obj_thang->Subject;
		$mail_text = imap_fetchbody($Mail,$what_ever,1);

		//Then spit it out below.........if you dont swallow
		echo "<div align=center><br /><font face=Arial size=2 color=#800000>Message ID# " . $what_ever . "</font>

		<table bgcolor=#D3D3D3 width=900 border=1 bordercolor=#000000 cellpadding=0 cellspacing=0>
		<tr>
			<td bgcolor=#F8F8FF><font face=Arial size=2 color=#800000>Date:</font> <font face=Arial size=2 color=#000000>" . date("d-m-Y H:i", $obj_thang->udate) . "</font></td>
			<td bgcolor=#F8F8FF><font face=Arial size=2 color=#800000>From:</font> <font face=Arial size=2 color=#000000>" . $adress_from . "</font></td>
			<td bgcolor=#F8F8FF><font face=Arial size=2 color=#800000>To:</font> <font face=Arial size=2 color=#000000>" . $adress_to . " </font></td>
		</tr>
		<tr>
			<td colspan=3 bgcolor=#F8F8FF><font face=Arial size=2 color=#800000>Subject:</font> <font face=Arial size=2 color=#000000>" . $mail_betreff . "</font></td>
		</tr>
		<tr>
			<td colspan=3 bgcolor=#F8F8FF><font face=Arial size=2 color=#800000>Text:</font> <font face=Arial size=2 color=#000000>" . $mail_text . "</font></td>
		</tr>
		</table>";
		}
	}

// date("d-m-Y H:i", $obj_thang->udate)

$str = 'RGllcyBpc3QgZWluIHp1IGtvZGllcmVuZGVyIFN0cmluZw==';
echo base64_decode($str);

?>
</Tr> </td> </table>

<HR>
<DIV>Based on: http://www.php.net/manual/de/function.imap-headerinfo.php</DIV>

</Body>
</Html>
