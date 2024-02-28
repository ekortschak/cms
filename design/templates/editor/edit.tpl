[dic]
conv = Save as
sure = Sure?
clip = Copy to clipboard
apply = Save

[dic.de]
conv = Speichern als
sure = Sicher?
clip = In Zwischenablage kopieren
apply = Speichern

[vars]
placeholder =
rows = 7


# ***********************************************************
[submit]
# ***********************************************************
<div class="toolbar flex" style="margin: 3px 0px 12px;">
<div><!SEC:restore!></div>
<div><!SEC:drop.file!></div>
<div>
	<input type="text" name="filName" value="<!VAR:file!>" class="filename" />
<!SEC:save.file!>
</div>
</div>

# ***********************************************************
[submit.simple]
# ***********************************************************
<div style="text-align: right; margin: 5px 0px;">
	<button name="file.act" value="save" onclick="exSubmit();">
		<img src="LOC_ICO/buttons/save.png" />
	</button>
</div>

# ***********************************************************
[ctarea]
# ***********************************************************
<textarea id="content" name="content" class="max" style="min-height: <!VAR:rows!>rem;"
placeholder="<!VAR:placeholder!>" tabindex=0 _
autocomplete="off" autocorrect="off" autocapitalize="off" _
spellcheck="false"><!VAR:content!></textarea>

# ***********************************************************
# other
# ***********************************************************
[restore]
	<a href="?file.act=backup&fil=<!VAR:file!>">
		<div class="dmbtn"><img src="LOC_ICO/buttons/backup.png" /></div>
	</a>
	<a href="?file.act=restore&fil=<!VAR:file!>">
		<div class="dmbtn"><img src="LOC_ICO/buttons/restore.png" /></div>
	</a>

[drop.file]
	<a href="?file.act=drop&fil=<!VAR:file!>" onclick="return confirm('<!DIC:ask.sure!>');">
		<div class="dmbtn">BOOL_NO</div>
	</a>

[drop.cms]
	<label class="blue"><grey>&cross;</grey> CMS</label>

[save.file]
	<button name="file.act" value="save" onclick="exSubmit();">
		<img src="LOC_ICO/buttons/save.png" />
	</button>

[save.cms]
	<button name="file.act" value="save"  onclick="exSubmit();">
		<img src="LOC_ICO/buttons/add.png" />
	</button>
