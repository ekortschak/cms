[include]
LOC_TPL/menus/dropBox.tpl

[register]
LOC_SCR/inline.js


[main.one]
<!SEC:combo!>


[combo]
<div class="dropdown">
<div class="droptext"><button>Snips COMBO_DOWN</button></div>
<div class="dropbody"><!VAR:links!></div>
</div>

[uniq]

[link]
<div><a href="javascript:exIns('<!VAR:value!>');"><!VAR:caption!></a></div>
