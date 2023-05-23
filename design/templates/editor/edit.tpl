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
<divstyle="text-align: right; margin: 5px 0px;">
	<button name="file.act" value="save" onclick="exSubmit();">
		<img src="LOC_ICO/buttons/save.png" />
	</button>
</div>

# ***********************************************************
[ctarea]
# ***********************************************************
<textarea id="content" name="content" class="max" rows="<!VAR:rows!>" _
placeholder="<!VAR:placeholder!>" tabindex=0 _
autocomplete="off" autocorrect="off" autocapitalize="off" _
spellcheck="false"><!VAR:content!></textarea>

# ***********************************************************
# other
# ***********************************************************
[restore]
	<a href="?file.act=backup&fil=<!VAR:file!>">
		<img class="btn" src="LOC_ICO/buttons/backup.png" />
	</a>
	<a href="?file.act=restore&fil=<!VAR:file!>">
		<img class="btn" src="LOC_ICO/buttons/restore.png" />
	</a>

[drop.file]
	<a href="?file.act=drop&fil=<!VAR:file!>" onclick="return confirm('<!DIC:ask.sure!>');">
		<label>BOOL_NO</label>
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
