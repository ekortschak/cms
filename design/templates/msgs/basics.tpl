[vars]
history = tstatus: OK
tstatus = BOOL_NO


# ***********************************************************
[main]
# ***********************************************************
<!SEC:notpl!>

[notpl]
<div class="dropdown pre"><img src="LOC_ICO/buttons/file.missing.png" alt="load error"> <!VAR:tplfile!>COMBO_DOWN _
<div class="dropbody">_
BOOL_NO Section: <!VAR:section!> <hr><!VAR:history!> _
</div> _
</div>

# ***********************************************************
[tplitem.1]
# ***********************************************************
<div><a><!VAR:tplitem!></a></div>

[tplitem.0]
<div><red><!VAR:tplitem!></red></div>

# ***********************************************************
[oid]
# ***********************************************************
<input type="hidden" name="oid" value="<!VAR:oid!>">

# ***********************************************************
[debug]
# ***********************************************************
<div class="dropdown pre head">&spades; <!VAR:tplfile!>COMBO_DOWN _
<div class="dropbody"> _
<!VAR:tstatus!> Section: <!VAR:section!> <hr><!VAR:history!> _
</div> _
</div>
