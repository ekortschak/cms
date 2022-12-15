[include]
design/templates/msgs/no.access.tpl
design/templates/user/login.tpl

[dic]
head  = Do you want to log out?
leave = Log out
done  = You are (now) logged out!

[dic.de]
head  = Wollen Sie sich abmelden?
leave = Abmelden
done  = Sie sind (nun) abgemeldet!


# ***********************************************************
[main]
# ***********************************************************
<!SEC:current!>

<h4><!DIC:head!></h4>

<div>
<form method="post" action="?">

	<input type="hidden" name="crdu" value="www" />
	<input type="hidden" name="crdp" value="none" />
	<input type="submit" name="B1" value="<!DIC:leave!>" />

</form>
</div>

# ***********************************************************
[done]
# ***********************************************************
<msg><!DIC:done!></msg>