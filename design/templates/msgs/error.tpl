[register]

[dic]
err = Info

[dic.de]
err = Hinweis


[main]
<div>
<err class="dropdown">E<!VAR:errNum!> _
<div class="dropdown-content err">
	<div class="err"><!VAR:errMsg!></div>
	<div class="err1"><b><!VAR:line!></b> <!VAR:file!></div>
	<div><!VAR:items!></div>
</div>
</err>
</div>

# ***********************************************************
[trace]
# ***********************************************************
<div class="err1">
<!VAR:items!>
</div>

[short]
<b><!VAR:line!></b> <!VAR:class!><blue>.<!VAR:function!></blue>(<green><!VAR:args!></green>)<br>

[item]
<div>
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
<h3>Fatal Error [<!VAR:type!>]</h3>
<ul>
<li><!VAR:text!></li>
<li>in file <!VAR:file!></li>
<li>on line &num;<b><!VAR:line!></b></li>
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
