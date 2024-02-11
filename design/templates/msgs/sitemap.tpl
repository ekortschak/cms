[register]
#LOC_SCR/toc.view.js

[dic]
notyet = This page is not (yet) available.
empty = Folder is empty.

[dic.de]
notyet = Diese Seite ist (noch) nicht verfügbar.
empty = Ordner ist leer.

# ***********************************************************
[notyet]
# ***********************************************************
<msg>
<!DIC:notyet!>
</msg>

# ***********************************************************
[empty]
# ***********************************************************
<msg>
<!DIC:empty!>
</msg>

# ***********************************************************
[list]
# ***********************************************************
<table>
	<tr>
		<td style="padding-right:25px;"><ul><!VAR:items1!></ul></td>
		<td style="padding-right:25px;"><ul><!VAR:items2!></ul></td>
		<td style="padding-right:25px;"><ul><!VAR:items3!></ul></td>
	</tr>
</table>


[item]
	<li><a href="?pge=<!VAR:link!>"><!VAR:text!></a></li>

[item2]
	<li><a href="?pge=<!VAR:link!>">
		<button class='menuOption'><!VAR:text!></button>
	</a></li>
