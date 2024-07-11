[dic]
confirm = Confirmation required
check = Preview
ok = YES, I want this now!

[dic.de]
confirm = Bestätigung erforderlich
check = Preview
ok = JA, genau das will ich jetzt!

[vars]
tpl = sql
link = ?

button = <!DIC:ok!>


# ***********************************************************
[main]
# ***********************************************************
<div style="margin: 12px 0px 7px;">
<form method="post" action="<!VAR:link!>">
<!SEC:oid!>

	<div class="rh"><!DIC:confirm!></div>
	<div class="confirm"><!VAR:items!></div>
	<div class="rf" align="right">
		<input type="submit" name="cnf.act" value="<!VAR:button!>" />
	</div>
</form>
</div>


[main.item]
<div><!VAR:msg!></div>


# ***********************************************************
[done]
# ***********************************************************
<h5>Info</h5>
<p>Pending action has been executed!</p>

[done.de]
<h5>Info</h5>
<p>Angefragte Aktion wurde ausgeführt!</p>
