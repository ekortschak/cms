[vars]
history = tpl stack: empty
tstatus = BOOL_NO


# ***********************************************************
[main]
# ***********************************************************
<pre>
<div class="dropdown"><img src="LOC_ICO/buttons/file.missing.png" class="icon" alt="load error"> <!VAR:tplfile!>
<div class="dropbody"><!SEC:missing!><!VAR:history!></div>
</pre>

# ***********************************************************
[tplitem.1]
# ***********************************************************
<div><a><!VAR:tplitem!></a></div>

[tplitem.0]
<div><red><!VAR:tplitem!></red></div>

[missing]
<div style="padding-left: IB_PAD;"><b>Section</b> <!VAR:section!> &rarr; BOOL_NO</div>_
<hr class="low">_

# ***********************************************************
[oid]
# ***********************************************************
<input type="hidden" name="oid" value="<!VAR:oid!>">
