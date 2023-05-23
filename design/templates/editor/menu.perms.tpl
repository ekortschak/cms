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
<!SEC:oid!>

	<table>
		<tr class="rh">
			<th><!DIC:user!></th>
			<th><!DIC:grant!><sup>1</sup></th>
			<th><!DIC:inherit!><sup>2</sup></th>
			<th><!DIC:deny!></th>
		</tr>
<!VAR:items!>
		<tr class="rf">
			<td colspan="100%" align="right">
				<input type="submit" name="perms.act" value="OK" style="padding:0px 20px;">
			</td>
		</tr>
	</table>
<div style="height: 5px;"></div>
<!SEC:explain!>
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
[explain]
# ***********************************************************
<small>
<table>
	<tr>
		<td><sup>1</sup></td> <td>Grant access for current folder and subfolders</td>
	</tr>
	<tr>
		<td><sup>2</sup></td> <td>Inherit permissions from parent folders</td>
	</tr>
</table>
</small>

# ***********************************************************
[explain.de]
# ***********************************************************
<small>
<table>
	<tr>
		<td><sup>1</sup></td> <td>Zugriff für aktuellen Ordner und Unterordner gestatten</td>
	</tr>
	<tr>
		<td><sup>2</sup></td> <td>Zugriff von übergeordneten Ordnern übernehmen</td>
	</tr>
</table>
</small>

# ***********************************************************
[info]
# ***********************************************************
<h4>Info</h4>
<p>Users are defined by <dfn>config/users.ini</dfn>.
<p>As soon as there are users with the "grant" or "deny" option this will <b>automatically exclude all unidentified users</b>
from accessing that folder or any subfoder therof.</p>

# ***********************************************************
[info.de]
# ***********************************************************
<h4>Info</h4>
<p>Benutzer werden in <dfn>config/users.ini</dfn> definiert.
<p>Sobald in einem Ordner einzelne Benutzer "Zugang" erhalten oder ausgeschlossen werden, sind <b>unangemeldete Benutzer</b> von diesem Ordner und
allen seinen Unterordnern <b>automatisch ausgeschlossen</b>.</p>
