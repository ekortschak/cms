[vars]
from = MAILMASTER
replyto = NOREPLY
subject = <!DIC:subject!>
[dic]
preview = This mail would have been sent ...
subject = No subject
noMsg   = Message has not been defined!

[dic.de]
preview = Diese Mail wäre nun verschickt worden ...
subject = Ohne Betreff
noMsg   = Es wurde keine Nachricht definiert!


[main]
<!SEC:message!>

[message]
<msg><!DIC:noMsg!></msg>


[preview]
<h5><!DIC:preview!></h5>
<code>
MIME-Version: 1.0
X-Mailer: PHP <!VAR:version!>
Content-type: text.html; charset=iso-8859-1
<hr>_
From: <!VAR:from!>
To: <!VAR:recipients!>
Reply-To: <!VAR:replyto!>
<hr>_
Subject: <!VAR:subject!>
Message: <!VAR:message!>
<hr>_
Total: <!VAR:count!>

<!VAR:msg!></code>
<br>
