[include]
LOC_TPL/user/login.tpl

[dic]
ask = Do you want to delete your account?
pwd = Password
del = Delete
inv = Password is invalid!
done = Your account has been deleted!

[dic.de]
ask = Wollen Sie Ihr Benutzerkonto löschen?
pwd = Passwort
del = Löschen
inv = Passwort ist ungültig!
done = Ihr Benutzerkonto wurde gelöscht!


# ***********************************************************
[main]
# ***********************************************************
<!SEC:current!>

<h4><!DIC:ask!></h4>

<div>
<form method="post" action="?vmode=login&btn.usr=D">

	<table>
		<tr>
			<td style="vertical-align: middle"><!DIC:pwd!> &emsp;</td>
			<td><input type="password" name="md5" autofocus></td>
		</tr>

    	<tr height=7><td colspan="100%"></td></tr>

		<tr>
			<td>&nbsp;</td>
			<td align="right">
				<input type="submit" name="B1" value="<!DIC:del!>" />
			</td>
		</tr>
	</table>

</form>
</div>


# ***********************************************************
[deleted]
# ***********************************************************
<msg><!DIC:done!></msg>

# ***********************************************************
[error]
# ***********************************************************
<err><!DIC:inv!></err>
<!DIC:nav.back!>
