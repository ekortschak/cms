[dic]
msg = For your information
err = Critical error

[dic.de]
msg = Zur Info
err = Kritischer Fehler


# ***********************************************************
[msgs.show]
# ***********************************************************
#<h5><!DIC:msg!></h5>

<div><msg>
<!VAR:items!>
</msg></div>

# ***********************************************************
[error.show]
# ***********************************************************
#<h5><!DIC:err!></h5>

<div><err>
<!VAR:items!>
</err></div>

# ***********************************************************
[item]
# ***********************************************************
<div><!VAR:item!></div>

[urlimg]
<a href="<!VAR:url!>" target="lup"><img src="LOC_ICO/buttons/web.gif" /></a>
