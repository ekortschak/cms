[include]
LOC_DIC/CUR_LANG/login.dic
LOC_TPL/msgs/no.access.tpl

[dic]
admin = This feature requres DB-admin privileges!
user = Account
pwd = Password
login = Login
cancel = Cancel

[dic.de]
admin = Dieser Bereich erfordert DB-Administrator-Rechte!
user = Benutzer
pwd = Passwort
login = Anmelden
cancel = Abbrechen


# ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:usr.chg!></h4>

<div>
<form method="post" action="?">

	<table>
		<tr>
			<td style="vertical-align: middle"><!DIC:user!> &emsp;</td>
			<td><input type="text" name="crdu" placeholder="CUR_USER" size="25" maxlength="25" autofocus /></td>
		</tr>

		<tr>
			<td style="vertical-align: middle"><!DIC:pwd!> &emsp;</td>
			<td><input type="password" name="crdp" placeholder="pwd" value="" size="25" maxlength="32"></td>
		</tr>

    	<tr height=7><td colspan="100%"></td></tr>

		<tr>
			<td>&nbsp;</td>
			<td align="right">
				<a href="?vmode=view"><input type="reset" name="B2" value="<!DIC:cancel!>" /></a>
				<input type="submit" name="B1" value="<!DIC:login!>" />
			</td>
		</tr>
	</table>

</form>
</div>

# ***********************************************************
[admin]
# ***********************************************************
<msg><!DIC:admin!></msg><br>
<!SEC:main!>

[login]
<msg><!DIC:nav.login!></msg><br>

[current]
<msg><!DIC:usr.current!></msg><br>

[success]
<msg><!DIC:done!></msg><br>

# ***********************************************************
[error]
# ***********************************************************
<err>Your credentials do not match any registered account.</err><br>
<msg>Anyway: <!DIC:done!></msg>

[error.de]
<err>Ihre Eingaben entsprechen keinem registrierten Benutzerkonto!</err><br>
<msg>Trotzdem: <!DIC:done!></msg>

# ***********************************************************
[force.logout]
# ***********************************************************
<h4>Forced logout</h4>
<ul>
	<li>inactivity timeout = TIMEOUT minutes</li>
	<li>at midnight (server time)</li>
</ul>

[force.logout.de]
<h4>Automatische Abmeldung</h4>
<ul>
	<li>bei Inaktivität nach TIMEOUT Minuten</li>
	<li>um Mitternacht (Server-Zeit)</li>
</ul>

# ***********************************************************
[nologin]
# ***********************************************************
<p>No login required on localhost ...<br>
<a href="?vmode=view">Continue</a>
</p>
<br>

# ***********************************************************
[nologin.de]
# ***********************************************************
<p>Am Localhost wird kein Login benötigt ...<br>
<a href="?vmode=view">Weiter</a>
</p>
<br>
