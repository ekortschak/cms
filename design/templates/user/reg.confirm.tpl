[include]
LOC_TPL/msgs/no.access.tpl

[dic]
head    = Confirm your account
code    = Access code
caption = Yes, I am real

[dic.de]
head    = Bestätigen Sie Ihr Benutzerkonto
code    = Zugangscode
caption = Ja, ich lebe wirklich


# ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:head!></h4>

<div>
<form method="post" action="?vmode=login&btn.usr=C">

	<table>
		<tr>
			<td style="vertical-align: middle"><!DIC:code!> &emsp;</td>
			<td><input type="text" name="md5" value="<!VAR:md5!>" size="32" maxlength="32" autofocus /></td>
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
[done]
# ***********************************************************
<h4>You succeeded</h4>
<p>Your account is now acitve.</p>

<ul>
	<li>Go to <a href="?vmode=login&btn.usr=L">login</a> page</li>
	<li>Go to <a href="?tab=home&pge=t">start</a> page</li>
</ul>

[done.de]
<h4>Geschafft</h4>
<p>Dein Benutzerkonto ist nun aktiviert.</p>

<ul>
	<li>Zur <a href="?vmode=login&btn.usr=L">Anmeldung</a></li>
	<li>Zur <a href="?tab=home&pge=">Startseite</a></li>
</ul>


# ***********************************************************
[error]
# ***********************************************************
<h4>Error</h4>
<p>The access code does not match!<br>
<!DIC:nav.back!></p>

[error.de]
<h4>Fehler</h4>
<p>Der Zugangscode ist ungültig!<br>
<!DIC:nav.back!></p>
