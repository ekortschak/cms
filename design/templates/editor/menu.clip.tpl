[dic]
clip.add = Cut current menu item
clip.cut = move to clipboard
clip.cpy = copy to clipboard
clip.del = &nbsp;&rdsh; drop this entry
clip.out = Append to current menu item
sure     = Sind Sie sicher?

[dic.de]
clip.add = Ausgewählten Menüpunkt ausschneiden
clip.cut = ins Clipboard verschieben
clip.cpy = ins Clipboard kopieren
clip.del = &nbsp;&rdsh; diesen Eintrag entfernen
clip.out = An ausgewählten Menüpunkt anhängen
sure     = Sind Sie sicher?


# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
<!SEC:copy!>
</form>

<form method="post" action="?">
<!SEC:paste!>
</form>

# ***********************************************************
# clipboard options
# ***********************************************************
[copy]
<h4><!DIC:clip.add!></h4>

<table>
	<tr>
		<td width=250 style="vertical-align: middle;"><!DIC:clip.cut!></td>
		<td><button name="clip_act" value="cut"><img src="LOC_ICO/edit/cut.png" /></button></td>
	</tr>
	<tr><td colspan="100%" height=2></td></tr>
	<tr>
		<td width=250 style="vertical-align: middle;"><!DIC:clip.cpy!></td>
		<td><button name="clip_act" value="copy"><img src="LOC_ICO/edit/copy.png" /></button></td>
	</tr>
</table>

[paste]
<h4><!DIC:clip.out!></h4>

<table>
	<tr>
		<td width=250><!VAR:box!></td>
		<td><button name="clip_act" value="paste"><img src="LOC_ICO/edit/paste.png" /></button></td>
	</tr>
	<tr>
		<td width=250 style="vertical-align: middle;"><!DIC:clip.del!></td>
		<td><button name="clip_act" value="del">BOOL_NO</button></td>
	</tr>
</table>
