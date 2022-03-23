[include]
design/templates/input/selector.tpl

[dic]
question = Question
done = Done
reset = Reset

[dic.de]
question = Frage
done = Fertig

[vars]
count = 0
fst = 1
lst = 1


[open]
<form method="post" action="?">
	<input type="hidden" name="oid" value="<!VAR:oid!>" />
	<input type="hidden" name="cur" value="<!VAR:cur!>" />

	<h4><!VAR:ask!></h4>
<!SEC:infox!>

	<div>

[close]
	</div>
<!SEC:footer!>
</form>


# ***********************************************************
[SubSection]
# ***********************************************************
&nbsp;

# ***********************************************************
[rows]
# ***********************************************************
	<!VAR:data!>

[footer]
<hr class=="low">
<table width="100%">
	<tr>
		<td><!DIC:question!> <!VAR:fst!>/<!VAR:lst!></td>
		<td align="right"><!SEC:btn.ok!></td>
	</tr>
</table>

<hr class=="low">

# ***********************************************************
[btn.ok]
# ***********************************************************
<input type="submit" name="nav" value="◂" />
<input type="submit" name="nav" value="▸" />

[btn.fst]
<input type="submit" disabled value="&nbsp;" />
<input type="submit" name="nav" value="▸" />

[btn.lst]
<input type="submit" name="nav" value="◂" />
<input type="submit" name="nav" value="Fertig" />

# ***********************************************************
[results]
# ***********************************************************
<h4><!VAR:head!></h4>
<p>Aktuell: <green><!VAR:count!></green> Teilnehmer</p>

<table>
<!VAR:items!>
</table>

<form method="post" action="?">
<!SEC:footer!>
</form>

[result]
<tr>
	<td><!VAR:option!> &nbsp; </td>
	<td width=35 align="right"><!VAR:width!>%</td>
	<td nowrap width="*">
		<span style="background-color: lightgrey;">
		<img src="core/icons/1x1.gif" width="<!VAR:width!>" height=10 />
		</span>
	</td>
</tr>
