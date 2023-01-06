[dic]
title = Set permissions
user  = User
perms = Permissions
inherit = inherit
grant = grant access
deny = deny

[dic.de]
title = Berechtigungen setzen
user  = Benutzer
perms = Zugang
inherit = übernehmen
grant = erlauben
deny = verweigern

# ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:title!></h4>
<!SEC:data!>
<!SEC:info!>

[data]
<form method="post" action="?">
	<table>
		<tr class="rh">
			<th width=120><!DIC:user!></th>
			<th><!DIC:grant!></th>
			<th><!DIC:inherit!></th>
			<th><!DIC:deny!></th>
		</tr>
<!VAR:items!>

		<tr class="rf">
			<td colspan="100%" align="right">
				<input type="submit" name="perms.act" value="OK" style="padding:0px 20px;">
			</td>
		</tr>
	</table>
</form>

[item]
<tr class="rw">
	<td><!VAR:user!></td>
	<td align="center">
		<input type="radio" id="<!VAR:user!>.r" name="<!VAR:user!>" value="r" <!VAR:r!>>
		<label for="<!VAR:user!>.r" class="hidden"></label>
	</td><td align="center">
		<input type="radio" id="<!VAR:user!>.i" name="<!VAR:user!>" value="i" <!VAR:i!>>
		<label for="<!VAR:user!>.i" class="hidden"></label>
	</td><td align="center">
		<input type="radio" id="<!VAR:user!>.d" name="<!VAR:user!>" value="d" <!VAR:d!>>
		<label for="<!VAR:user!>.d" class="hidden"></label>
	</td>
</tr>

# ***********************************************************
[info]
# ***********************************************************
<h4>Info</h4>
<h4>Explanation</h4>
<table>
	<tr>
		<td><!DIC:grant!></td>
		<td>Grant access</td>
	</tr>
	<tr>
		<td><!DIC:grant!></td>
		<td>Inherit permissions from parent folders</td>
	</tr>
</table>

<p>Users are defined by <dfn>config/users.ini</dfn>.
<p>As soon as there are users with the "grant" option this will automatically exclude all other users
from accessing that folder or any subfoder therof.</p>

# ***********************************************************
[info.de]
# ***********************************************************
<h4>Legende</h4>
<table>
	<tr>
		<td><!DIC:grant!></td>
		<td>Zugriff gestatten</td>
	</tr>
	<tr>
		<td><!DIC:inherit!></td>
		<td>Zugriff von übergeordneten Ordnern übernehmen</td>
	</tr>
</table>

<h4>Info</h4>
<p>Benutzer werden in <dfn>config/users.ini</dfn> definiert.
<p>Sobald in einem Ordner einzelne Benutzer "Zugang" erhalten, sind alle anderen von diesem Ordner und
allen seinen Unterordnern automatisch ausgeschlossen.</p>
