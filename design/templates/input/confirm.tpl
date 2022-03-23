[dic]
confirm = Confirmation required
ok = YES, I want this now!

[dic.de]
confirm = Bestätigung erforderlich
ok = JA, genau das will ich jetzt!

[vars]
tpl = sql
tspace = 12
bspace = 7
link = ?


# ***********************************************************
[main]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<form method="post" action="<!VAR:link!>">

	<div class="rh"><!DIC:confirm!></div>
	<div class="confirm"><!VAR:items!></div>
	<div class="rf" align="right">
		<input type="hidden" name="oid" value="<!VAR:oid!>" />
		<input type="submit" name="cnf.act" value="<!DIC:ok!>" />
	</div>
</form>
</div>


[main.item]
<div><!VAR:msg!></div><nolf>

# ***********************************************************
[done]
# ***********************************************************
<h5>Info</h5>
<p>Pending action has been confirmed!</p>

[done.de]
<h5>Info</h5>
<p>Angefragte Aktion wurde bestätigt!</p>
