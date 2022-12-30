[include]
LOC_TPL/msgs/no.access.tpl
LOC_TPL/msgs/error.tpl

[dic]
text    = Upon sending this request you will receive an email containing a link. <br>_
	Follow that link in order to reset your password!

head    = Please enter your credentials
user    = Account
email   = EMail address
caption = Send
nomail  = Mailing is deactivated

[dic.de]
text  = Wenn Sie dieses Formular absenden, erhalten Sie eine EMail mit einem Link. <br>_
	Folgen Sie dem Link, um ihr Passwort zurückzusetzen!

head    = Bitte geben Sie Ihre Zugangsdaten ein
user    = Benutzerkonto
email   = EMail Adresse
caption = Senden
nomail  = Mailing ist deaktiviert.


# ***********************************************************
[main]
# ***********************************************************
<!SEC:current!>

<h4><!DIC:head!></h4>

<div>
<form method="post" action="?vmode=login&btn.usr=F">

	<table>
		<tr>
			<td style="vertical-align: middle"><!DIC:user!> &emsp;</td>
			<td><input type="text" name="crdu" value="CUR_USER" size="25" maxlength="25" autofocus /></td>
		</tr>

		<tr>
			<td style="vertical-align: middle"><!DIC:email!> &emsp;</td>
			<td><input type="text" name="mail" placeholder="nobody@home.net" size="25" maxlength="32" /></td>
		</tr>

    	<tr height=7><td colspan="100%"></td></tr>

		<tr>
			<td>&nbsp;</td>
			<td align="right">
				<input type="submit" name="B1" value="<!DIC:caption!>" />
			</td>
		</tr>
	</table>

</form>
</div>


# ***********************************************************
[cfg.usemail]
# ***********************************************************
<msg><!DIC:nomail!></msg><br>

# ***********************************************************
[dberror]
# ***********************************************************
<msg>An error occurred while updating database ...</msg><br>

[dberror.de]
<msg>Die Datenbank konnte nicht aktualisiert werden ...</msg><br>

# ***********************************************************
[mail.error]
# ***********************************************************
<msg><!DIC:mail.failed!></msg><br>


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
