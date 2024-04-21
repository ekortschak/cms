[vars]
history = tstatus: OK
tstatus = BOOL_NO


# ***********************************************************
[main]
# ***********************************************************
<!SEC:notpl!>

[notpl]
<pre>
<div class="dropdown"><img src="LOC_ICO/buttons/file.missing.png" alt="load error"> <!VAR:tplfile!>COMBO_DOWN
<div class="dropbody"><!SEC:missing!><!VAR:history!></div>
</div>
</pre>

# ***********************************************************
[tplitem.1]
# ***********************************************************
<div><a><!VAR:tplitem!></a></div>

[tplitem.0]
<div><red><!VAR:tplitem!></red></div>

[missing]
<div style="padding-left: 5px;"><b>Section</b> <!VAR:section!> &rarr; BOOL_NO</div>_
<hr class="low">_

# ***********************************************************
[oid]
# ***********************************************************
<input type="hidden" name="oid" value="<!VAR:oid!>">
