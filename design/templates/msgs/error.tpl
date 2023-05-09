[dic]
err = Info

[dic.de]
err = Hinweis


[main]
<div><err class="dropdown">E<!VAR:errNum!> _
<div class="dropbody err"> _
	<div class="err"><!VAR:errMsg!></div> _
	<div class="err1"><b><!VAR:line!></b> <!VAR:file!></div> _
	<div><!VAR:items!></div> _
</div> _
</err> _
</div>

# ***********************************************************
[trace]
# ***********************************************************
<div class="err1 scroll">
<!VAR:items!>
</div>

[short]
<div style="white-space: nowrap;"> _
<b><!VAR:line!></b> <!VAR:class!><blue>.<!VAR:function!></blue>(<green><!VAR:args!></green>) _
</div> _

[item]
<div style="white-space: nowrap; font-size: 0.75em;">
<b><!VAR:line!></b> <!VAR:file!><br>
&nbsp;<!VAR:class!><blue>.<!VAR:function!></blue>(<green><!VAR:args!></green>)
</div>

# ***********************************************************
[dump]
# ***********************************************************
<dbg><!VAR:head!>: <!VAR:data!></dbg><br>

[dump.array]
<dbg><pre>
<!VAR:data!>Total: <!VAR:head!> items
</pre></dbg><br>

# ***********************************************************
[fatal]
# ***********************************************************
<hr>
Error \#<!VAR:type!>
<hr>
<p>in <!VAR:file!> on <b><!VAR:line!></b></p>;
<pre><!VAR:message!></pre>

<h1>What can you do?</h1>
<ul>
<li><a href="?vmode=pedit">Enter edit mode</a></li>
<li><a href="?reset=1">Reset session</a></li>
<li><a href="?">Reload</a></li>
</ul>

# ***********************************************************
[msgs.show]
# ***********************************************************
<err>
<b><!DIC:err!></b>
<ul>
<!VAR:items!>
</ul>
</err>
<br>

[error.item]
<li><!VAR:item!></li>
