[register]
core/scripts/selRec.js

[include]
design/templates/tables/std.tpl

[dic]
grant = Grant

[dic.de]
grant = Erlaube

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
	<input type="hidden" name="oid" value="<!VAR:oid!>" />

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
			<input type="checkbox" name="sel[<!VAR:recid!>]" class="cb" />
		</td>
		<!VAR:data!>
	</tr>

[TCols]
	<tr class="<!VAR:class!>">
		<th align="center"><img src="core/icons/nav/OK.gif" onClick="toggleCB();" /></th>
		<!VAR:data!>
	</tr>

[TFoot]
	<tr class="rf">
        <td colspan="100%" align="right"><!DIC:grant!>:
        	<input name="rec.act" type="submit" value="<!VAR:action!>" />
        </td>
	</tr>
