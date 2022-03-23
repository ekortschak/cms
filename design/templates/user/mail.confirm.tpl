[include]
design/templates/user/mail.std.tpl

[dic]
subject = Confirm your account!

[dic.de]
subject = Bestätigen Sie Ihr Konto!


[message]
<pre>
**********************************************************
Automatic email - do not reply !
**********************************************************
You have requested an account with http://www.glaubeistmehr.at/
as follows:

UName = <!VAR:uname!>
EMail = <!VAR:email!>
Pwd   = <!VAR:pwd!>

<b>Options</b>
- <a href="http://www.glaubeistmehr.at/?tab=user&pge=acc.confirm&code=<!VAR:md5!>">Confirm</a> account creation

**********************************************************
Automatic email - do not reply !
**********************************************************
</pre>

[message.de]
<pre>
**********************************************************
Automatisch erstellte EMail - bitte nicht antworten !
**********************************************************
Sie haben einen Benutzerzugang für http://www.glaubeistmehr.at/
mit folgenden Daten angefordert:

UName = <!VAR:uname!>
EMail = <!VAR:email!>
Pwd   = <!VAR:pwd!>

<b>Optionen</b>
- Benutzerkonto <a href="http://www.glaubeistmehr.at/?tab=user&pge=acc.confirm&code=<!VAR:md5!>">bestätigen</a>

**********************************************************
Automatisch erstellte EMail - bitte nicht antworten !
**********************************************************
</pre>
