[dic]
delete = Delete
reload = Reload
rename = Rename

[dic.de]
delete = Löschen
reload = Neu laden
rename = Umbenennen


[vars]
wid = 500
hgt = 360

# ***********************************************************
[main]
# ***********************************************************
<table>
	<tr>
		<td class="nopad"><!SEC:preview!></td>
		<td class="nopad">&nbsp;</td>
		<td class="nopad"><!SEC:opts!></td>
	</tr>
</table>

[preview]
<embed class="round7" width=<!VAR:wid!> height=<!VAR:hgt!> src="<!VAR:url!>" />

[opts]
<a href="?act=d"><button>BOOL_NO</button></a> <!DIC:delete!>
<br>
<a href="?"><button><img src="LOC_ICO/edit/undo.png"></button></a> <!DIC:reload!>


[dest]
<p>Verschieben nach:<br>&rarr; <!VAR:new!></p>

<div align="right">
<a href="?act=r"><button><!DIC:rename!></button></a>
</div>
