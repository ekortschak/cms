[include]
LOC_TPL/msgs/no.access.tpl
LOC_TPL/user/login.tpl

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

<form method="post" action="?">
<!SEC:oid!>
	<input type="submit" name="B1" value="<!DIC:leave!>" />
</form>

# ***********************************************************
[done]
# ***********************************************************
<msg><!DIC:done!></msg>
