[register]
core/scripts/embedded.js

[vars]
hgt = 500

[dic]
nofiles = Folder is empty!

[dic.de]
nofiles = Ordner ist leer!

# ***********************************************************
[main]
# ***********************************************************
<div style="overflow: auto; border: 1px solid grey; border-radius: 5px;">
<embed width="100%" height=<!VAR:hgt!> src="<!VAR:url!>" />
</div>

#<!SEC:info!>

[info]
<hint>If the file does not show automatically, it will after rescaling the viewport or pressing F5 or moving on and coming back.</hint>

[info.de]
<hint>Wenn die Datei nicht sofort angezeigt wird: F5 drücken oder Zoom-Faktor ändern oder weiterblättern und zurückkommen.</hint>
