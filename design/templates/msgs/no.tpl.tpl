[vars]
history = Status: OK
status = BOOL_NO


# ***********************************************************
[main]
# ***********************************************************
<!SEC:notpl!>

[notpl]
<div class="dropdown pre"><img src="ICONS/buttons/file.missing.png" style="vertical-align: bottom;" alt="load error"> <!VAR:tplfile!>COMBO_DOWN _
<div class="dropdown-content">_
Section called: <!VAR:section!> BOOL_NO<hr class="low"><!VAR:history!> _
</div> _
</div>

# ***********************************************************
[item.1]
# ***********************************************************
<div><!VAR:item!></div>

[item.0]
<div><red><!VAR:item!></red></div>


# ***********************************************************
[debug]
# ***********************************************************
<div class="dropdown pre head">&spades; <!VAR:tplfile!>COMBO_DOWN _
<div class="dropdown-content"> _
Section called: <!VAR:section!> <!VAR:status!><hr class="low"><!VAR:history!> _
</div> _
</div>

[debug.tell]
