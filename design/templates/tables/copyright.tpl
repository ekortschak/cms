[include]
design/templates/tables/recEdit.tpl

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
<!SEC:hidden!>

<table>
	<tr>
        <td width=110>&nbsp;</td>
        <td width=5 class="nopad" ><hint>*</hint></td>
        <td width="*"><hint><!DIC:mandatory!></hint></td>
	</tr>
    <!VAR:body!>
    <!SEC:buttons!>
</table>
</form>

<p></p>
