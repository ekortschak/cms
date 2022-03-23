[vars]
from = POSTMASTER
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
Content-type: text.html; charset=iso-8859-1
From: <!VAR:from!>
Reply-To: <!VAR:replyto!>
X-Mailer: PHP <!VAR:version!>
Subject: <!VAR:subject!>
Recipient(s): <!VAR:recipients!>
Total: <!VAR:count!>

<!VAR:msg!></code>
<br>
