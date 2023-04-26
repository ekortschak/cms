[register]
LOC_SCR/gallery.js

[dic]
head = Images
nofiles = Folder is empty!

[dic.de]
head = Bilddateien
nofiles = Ordner ist leer!


# ***********************************************************
[main]
# ***********************************************************
#<!SEC:location!>

<div><img id="pic" src="<!VAR:first!>" width="100%" /></div>
<div class="scroll" style="margin: 7px 0px 15px;"><!VAR:thumbs!></div>

# ***********************************************************
[files]
# ***********************************************************

[file]
<div class="thumb">
	<nobr><img src="LOC_ICO/files/file.gif" />
		<a href="javascript:setFile('<!VAR:url!>');">
			<!VAR:name!>
		</a>
	</nobr>
</div>

[thumb]
<a href="javascript:setFile('<!VAR:url!>');">
	<img class="thumb" src="<!VAR:icon!>" alt="<!VAR:name!> X" />
</a>

[nofiles]
<!DIC:nofiles!>

# ***********************************************************
[location]
# ***********************************************************
<p><small>dir = <!VAR:curloc!></small></p>
