[dic]
nodata = No filter specified!
mandatory = marks mandatory field
hint = Info

[dic.de]
nodata = Keine Daten vorhanden!
mandatory = markiert Pflichtfelder
hint = Hinweis


[vars]
cols = 69
wid = 150


# ***********************************************************
[main]
# ***********************************************************
<!SEC:open!>
<!VAR:items!>
<!SEC:close!>

[open]
<form method="post" action="?" enctype="multipart/form-data">
	<input type="hidden" name="oid" value="<!VAR:oid!>" />

	<table>
		<tr height=0>
			<td width="<!VAR:wid!>"></td>
			<td width="*"></td>
			<td width=75 rowspan="100%" style="vertical-align: bottom;" align="right">
				<!SEC:btn.ok!>
			</td>
		</tr>

[close]
	</table>
</form>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td class="selHead"><!VAR:head!> &nbsp; </td>
	<td class="selData"><!VAR:data!></td>
</tr>

[line]
# ***********************************************************
<tr>
	<td colspan="100%" class="selSection">
		<!VAR:head!>
	</td>
</tr>

# ***********************************************************
[span]
# ***********************************************************
<tr>
	<td colspan="100%" style="padding: 0px 7px;">
		<!VAR:head!>
	</td>
</tr>

# ***********************************************************
[NoData]
# ***********************************************************
<h5><!DIC:hint!></h5>
<p><!DIC:nodata!></p>

# ***********************************************************
[btn.ok]
# ***********************************************************
<input type="submit" name="act" value="OK" />

[btn.reset]
#<input type="reset" value="Reset" /> &emsp;
