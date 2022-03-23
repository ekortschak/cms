[dic]
nodata = No filter specified!
mandatory = marks mandatory field
hint = Info

[dic.de]
nodata = Keine Daten vorhanden!
mandatory = markiert Pflichtfelder
hint = Hinweis


[vars]
wid1 = 125
wid2 = *

# ***********************************************************
[main]
# ***********************************************************
<!SEC:open!>
<!VAR:items!>
<!SEC:close!>

[open]
<form method="post" action="?" enctype="multipart/form-data">
	<!SEC:hidden!>

	<table>
		<tr height=0>
			<td width="<!VAR:wid1!>"></td>
			<td width="<!VAR:wid2!>"></td>
			<td rowspan="100%" style="vertical-align: bottom;">
				<!SEC:btn.ok!>
			</td>
		</tr>

[close]
	</table>
</form>

# ***********************************************************
[Hidden]
# ***********************************************************
	<input type="hidden" name="oid" value="<!VAR:oid!>" />
	<input type="hidden" name="tan" value="<!VAR:tan!>" />
	<!VAR:hidden!>

[input.skip]
# show nothing

[input.hid]
<input type="hidden" name="val.<!VAR:fname!>" value="<!VAR:value!>" />

# ***********************************************************
[SubSection]
# ***********************************************************
<tr class="selSection"><td colspan="100%"><!VAR:title!></td></tr>

[spacer]
<tr height=12><td colspan="100%"></td></tr>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td class="selHead"><!VAR:head!> &nbsp; </td>
	<td class="selData"><!VAR:data!></td>
</tr>

# ***********************************************************
[rows.ronly]
# ***********************************************************
<tr>
	<td nowrap><!VAR:head!> &nbsp; </td>
	<td nowrap><!VAR:data!></td>
</tr>

# ***********************************************************
[NoData]
# ***********************************************************
<h5><!DIC:hint!></h5>
<p><!DIC:nodata!></p>

# ***********************************************************
[btn.ok]
# ***********************************************************
<input type="submit" name="<!VAR:oid!>.act" value="OK" />

[btn.reset]
#<input type="reset" value="Reset" /> &nbsp; &nbsp;
