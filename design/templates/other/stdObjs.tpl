[vars]
wid = 250
hgt = 150
link = "notyet"

[dic]
source = Source

[dic.de]
source = Quelle

[main]

[img.org]
<img src="<!VAR:file!>" />

[img.std]
<div style="margin: 0px 0px 7px;">
	<a href="<!VAR:file!>">
		<img src="<!VAR:file!>" width="100%">
	</a>
</div>

[img.src]
<div align="right">
	<!DIC:source!>: <a href="<!VAR:link!>"><!VAR:text!></a>
</div>

[thumb]
<a href="<!VAR:link!>"><img src="<!VAR:link!>" style="margin: 0px 3px 7px 0px;" width=<!VAR:wid!> height=<!VAR:hgt!> /></a>

[thumbR]
<a href="<!VAR:link!>"><img src="<!VAR:link!>" class="rgt" align="right" width=<!VAR:wid!> /></a>

[thumbL]
<a href="<!VAR:link!>"><img src="<!VAR:link!>" class="lft" align="left" width=<!VAR:wid!> height=<!VAR:hgt!> /></a>

# ***********************************************************
[yt.link]
# ***********************************************************
<p>
	<img src="ICONS/nav/youtube.png" style="margin-right: 5px;" />
	<a href="https://www.youtube.com/watch?v=<!VAR:ytid!>" target="_blank"><!VAR:title!></a>
	<hint><!VAR:len!> (ID = <!VAR:ytid!>)</hint>
</p>

[yt.frame]
<iframe width="540" height="270"
    src="https://www.youtube.com/embed/<!VAR:ytid!>"
    frameborder="0" allowfullscreen>
</iframe>
<p><!VAR:title!>: ~ <!VAR:len!> <hint>(ID = <!VAR:ytid!>)</hint></p>

# ***********************************************************
[mp4]
# ***********************************************************
<a href="<!VAR:link!>"><!VAR:text!> </a> <!VAR:hint!>&nbsp; 🎥<img src="ICONS/files/movie.png" />


# ***********************************************************
[no.lang]
# ***********************************************************
<hr>
<p>Sorry: this file is not (yet) available in English!</p>
<hr>

[no.lang.de]
<hr>
<p>Sorry: diese Datei ist in Deutsch (noch) nicht vorhanden!</p>
<hr>

