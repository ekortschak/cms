[include]
design/templates/msgs/no.access.tpl

[vars]
user  = CUR_USER

[dic]
req   = Min. requirements for secure passwords
req   = Password requirements
head  = Enter your new password
user  = User name
old   = Old password
pwd   = New password
chk   = Repeat password
snd   = Send

min   = Minimum password length is 6 characters
inv   = User data are invalid (old password)
mis   = password mismatch

[dic.de]
head  = Geben Sie Ihr neues Passwort ein
user  = Benutzername
old   = Altes Passwort
pwd   = Neues Passwort
chk   = Passwort wiederholen
snd   = Senden

min   = Passwort muß min. 6 Zeichen beinhalten
inv   = Benutzerdaten sind ungültig (altes Passwort)
mis   = Passwörter stimmen nicht überein

req   = Anforderungen an sichere Passwörter
req   = Password requirements
head  = Enter your new password
user  = User name
old   = Old password
pwd   = New password
chk   = Repeat password
snd   = Send

min   = Minimum password length is 6 characters
inv   = User data are invalid (old password)
mis   = password mismatch


# ***********************************************************
[main]
# ***********************************************************
<!SEC:pwd.req!>

<h4><!DIC:head!></h4>
<!VAR:uid!>

<div>
<form method="post" action="?vmode=login&btn.usr=R">

	<table>
		<tr>
			<td style="vertical-align: middle">CUR_USER &emsp;</td>
			<td><input type="text" name="crdu" value="<!VAR:user!>" size="20" readonly=1 /></td>
		</tr>

		<tr>
			<td style="vertical-align: middle"><!DIC:old!> &emsp;</td>
			<td><input type="password" name="opwd" autofocus></td>
		</tr>

		<tr>
			<td style="vertical-align: middle"><!DIC:pwd!> &emsp;</td>
			<td><input type="password" name="npwd"></td>
		</tr>

		<tr>
			<td style="vertical-align: middle"><!DIC:chk!> &emsp;</td>
			<td><input type="password" name="cpwd"></td>
		</tr>

    	<tr height=7><td colspan="100%"></td></tr>

		<tr>
			<td>&nbsp;</td>
			<td align="right">
				<input type="submit" name="B1" value="<!DIC:snd!>" />
			</td>
		</tr>
	</table>

</form>
</div>


# ***********************************************************
[info]
# ***********************************************************
<p>You should receive a confirmation mail shortly.<br>
Follow the link therein in order to activate your account!</p>

<h4>If you do not receive your confirmation request</h4>
<ul>
	<li>repeat the process</li>
	<li>double check the given recipient address</li>
</ul>

[info.de]
<p>Sie sollten in Kürze eine Bestätigungs-EMail erhalten.<br>
Folgen sie dem Link in der Email, um das Benutzerkonto zu aktivieren!</p>

<h4>Falls Sie keine EMail erhalten sollten</h4>
<ul>
	<li>Wiederholen Sie den Vorgang</li>
	<li>Überprüfen Sie ganz speziell die eingegebene EMail-Adresse</li>
</ul>

# ***********************************************************
[pwd.req]
# ***********************************************************
<h5>Password requirements</h5>
<ul>
	<li>contain letters, numbers and special characters</li>
	<li>minimum length = 6 characters</li>
</ul>

[pwd.req.de]
<h5>Anforderungen an sichere Passwörter</h5>
<ul>
	<li>enthalten Buchstaben, Ziffern und Sonderzeichen</li>
	<li>sind mindestens 6 Zeichen lang</li>
</ul>

# ***********************************************************
[pwd.min]
# ***********************************************************
<p><!DIC:min!><br><!DIC:nav.back!></p>

[invalid]
<p><!DIC:inv!><br><!DIC:nav.back!></p>

[mismatch]
<p><!DIC:mis!><br><!DIC:nav.back!></p>
