[dic]
mandatory = marks mandatory field
hint = Info

[dic.de]
mandatory = markiert Pflichtfelder
hint = Hinweis


[vars]
cols = 69

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?" enctype="multipart/form-data">
<!SEC:oid!>

	<div class="flexbottom">
		<div><!SEC:data!></div>
		<div><!SEC:btn.ok!></div>
	</div>
</form>

[data]
<table>
<!VAR:items!>
</table>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td class="selHead"><!VAR:head!></td>
	<td class="selData"><!VAR:data!></td>
</tr>

# ***********************************************************
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
[hidden]
# ***********************************************************
<!VAR:data!>

# ***********************************************************
[NoData]
# ***********************************************************
<h5><!DIC:hint!></h5>
<p><!DIC:no.data!></p>

# ***********************************************************
[btn.ok]
# ***********************************************************
<input type="submit" name="act" value="OK" />

[btn.reset]
#<input type="reset" value="Reset" /> &emsp;
