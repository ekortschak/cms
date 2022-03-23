[include]
design/templates/user/mail.std.tpl

[dic]
subject = Confirm your account!

[dic.de]
subject = Bestätigen Sie Ihr Konto!


[message]
**********************************************************
Automatic email - do not reply !
**********************************************************
EMail = <!VAR:email!>
UName = <!VAR:uname!>
Pwd   = <!VAR:pwd!>

<b>Options</b>
- <a href="http://www.glaubeistmehr.at/?tab=user&pge=pwd.reset&code=<!VAR:md5!>">Change password</a>

**********************************************************
Automatic email - do not reply !
**********************************************************


[message.de]
**********************************************************
Automatisch erstellte EMail - bitte nicht antworten !
**********************************************************
EMail = <!VAR:email!>
UName = <!VAR:uname!>
Pwd   = <!VAR:pwd!>

<b>Optionen</b>
- <a href="http://www.glaubeistmehr.at/?tab=user&pge=pwd.reset&code=<!VAR:md5!>">Passwort ändern</a>

**********************************************************
Automatisch erstellte EMail - bitte nicht antworten !
**********************************************************
