[dic]
start = Default page
useme = Yes/No

[dic.de]
start = Startseite
useme = Ja/Nein


# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
<!SEC:start!>
</form>

# ***********************************************************
[start]
# ***********************************************************
<table>
	<tr>
		<td class="selHead"><!DIC:start!></td>
		<td class="selData" width=355><input type="checkbox" name="overwrite" value="1" <!VAR:value!> />&nbsp; <!DIC:useme!></td>
		<td><button name="page_act" value="std">OK</button></td>
	</tr>
</table>

