[include]
design/templates/msgs/no.access.tpl
design/templates/user/login.tpl

[dic]
info = Your current data
saved = Changes have been stored!

[dic.de]
info = Ihre gespeicherten Daten
saved = Änderungen wurden gespeichert!


## ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:info!></h4>

# ***********************************************************
[done]
# ***********************************************************
<p><!DIC:saved!><br>
<a href="?"><!DIC:back!></a>
</p>
