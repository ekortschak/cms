[vars]
lines = 35
sql = Select * from ?

[dic]
nocols = No columns to display!
page = Page

[dic.de]
nocols = Keine Spalten zum Anzeigen!
page = Seite

# ***********************************************************
[main]
# ***********************************************************
<div class="bg">
	<table class="nomargin">
<!VAR:body!>
	</table>
<!SEC:TFoot!>
</div>

# ***********************************************************
[Heading]
# ***********************************************************
<h4><!VAR:title!></h4>

# ***********************************************************
[TRows]
# ***********************************************************
	<tr class="<!VAR:class!>">
		<!VAR:data!>
		<td width="100%">&nbsp;</td>
	</tr>

[TCols]
	<tr class="<!VAR:class!>">
		<!VAR:data!>
		<th width="100%">&nbsp;</th>
	</tr>

[TSums]

# ***********************************************************
[THead]
# ***********************************************************
		<th nowrap align="<!VAR:align!>"><!VAR:head!></th>

[TData]
		<td nowrap align="<!VAR:align!>"><!VAR:value!></td>

[TFoot]
<div class="flex rf" style="padding: 0px 5px;">
	<div><!SEC:stats!></div>
    <div><!SEC:nav!></div>
</div>

# ***********************************************************
[Nav]
# ***********************************************************
<a href="?act=f"><img src="ICONS/move/First.gif" alt="goto first"></a>
<a href="?act=p"><img src="ICONS/move/Left.gif"  alt="goto previous"></a>
<a href="?act=n"><img src="ICONS/move/Right.gif" alt="goto next"></a>
<a href="?act=l"><img src="ICONS/move/Last.gif"  alt="goto last"></a>

[stats]
<!DIC:page!> <!VAR:1st!> / <!VAR:cnt!>

[show.sql]
<div class="dropdown">SQL
	<div class="dropdown-content"><!VAR:sql!></div>
</div>

# ***********************************************************
[Break]
# ***********************************************************
	<tr height=1 bgcolor="maroon">
		<td colspan="100%"></td>
	</tr>
