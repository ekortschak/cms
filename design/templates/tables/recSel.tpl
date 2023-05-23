[register]
LOC_SCR/selRec.js

[include]
LOC_TPL/tables/std.tpl

[dic]
grant = Grant

[dic.de]
grant = Erlaube

[vars]
cls = cb

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
<!SEC:oid!>

<table width=350 border=0>
    <!VAR:body!>
    <!SEC:TFoot!>
</table>

</form>

# ***********************************************************
[TRows]
# ***********************************************************
	<tr class="<!VAR:class!>">
		<td nowrap align="center">
			<input type="checkbox" name="sel[<!VAR:recid!>]" class="<!VAR:cls!>">
		</td>
		<!VAR:data!>
	</tr>

[TCols]
	<tr class="<!VAR:class!>">
		<th align="center"><img src="LOC_ICO/nav/toggle.gif" onClick="toggleCB('<!VAR:cls!>');"></th>
		<!VAR:data!>
	</tr>

[TFoot]
	<tr class="rf">
        <td colspan="100%" align="right"><!DIC:grant!>:
        	<input name="rec.act" type="submit" value="<!VAR:action!>">
        </td>
	</tr>
