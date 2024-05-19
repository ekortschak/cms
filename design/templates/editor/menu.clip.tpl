[dic]
clip.add = Cut current menu item
clip.cut = move to clipboard
clip.cpy = copy to clipboard
clip.dup = dupplicate selected entry
clip.del = &nbsp;&rdsh; drop this entry
clip.out = Append to current menu item
sure     = Sind Sie sicher?

[dic.de]
clip.add = Ausgewählten Eintrag bearbeiten
clip.cut = ins Clipboard verschieben
clip.cpy = ins Clipboard kopieren
clip.dup = Ausgewählten Eintrag duplizieren
clip.del = &nbsp;&rdsh; diesen Eintrag entfernen
clip.out = An ausgewählten Eintrag anhängen
sure     = Sind Sie sicher?


# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
<!SEC:oid!>
<!SEC:copy!>
</form>

<form method="post" action="?">
<!SEC:oid!>
<!SEC:paste!>
</form>

<br>
<br>

<form method="post" action="?">
<!SEC:oid!>
<!SEC:dup!>
</form>


# ***********************************************************
# clipboard options
# ***********************************************************
[copy]
<h4><!DIC:clip.add!></h4>

<table>
	<tr>
		<td width=250><!DIC:clip.cut!></td>
		<td><button name="clip.act" value="cut"><img src="LOC_ICO/edit/cut.png" /></button></td>
	</tr>
	<tr><td colspan="100%" height=2></td></tr>
	<tr>
		<td width=250><!DIC:clip.cpy!></td>
		<td><button name="clip.act" value="copy"><img src="LOC_ICO/edit/copy.png" /></button></td>
	</tr>
</table>

[paste]
<h4><!DIC:clip.out!></h4>

<table>
	<tr>
		<td width=250><!VAR:box!></td>
		<td><button name="clip.act" value="paste"><img src="LOC_ICO/edit/paste.png" /></button></td>
	</tr>
	<tr>
		<td width=250"><!DIC:clip.del!></td>
		<td><button name="clip.act" value="del">BOOL_NO</button></td>
	</tr>
</table>

[dup]
<h4><!DIC:clip.dup!></h4>

<table>
	<tr>
		<td width=250>
			UID <input name="clip.uid" type="text" value="<!VAR:curuid!>" />
		</td>
		<td><button name="clip.act" value="dup"><img src="LOC_ICO/edit/copy.png" /></button></td>
	</tr>
</table>
