[include]
LOC_TPL/input/selector.tpl

[dic.de]
filter = Datenfilter
filtered = Passende Datensätze

[dic.xx]
filter = Use record filter
filtered = Filtered Records

[vars]
equal = &sime;

# ***********************************************************
[main]
# ***********************************************************
<h5><!DIC:filter!></h5>

<form method="post" action="?" style="padding: 0px; margin: 0px;">
<!SEC:oid!>

	<div class="flex flexbottom">
		<div><!SEC:data!></div>
		<div><!SEC:btn.ok!></div>
	</div>
</form>

<h5><!DIC:filtered!></h5>


# ***********************************************************
[data]
# ***********************************************************
<table>
<!VAR:items!>
</table>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td class="selHead"><!VAR:head!>  <!VAR:equal!>  </td>
	<td class="selData"><!VAR:data!></td>
</tr>
