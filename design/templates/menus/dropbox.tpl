[dic]
topics = Topics
topic = Topic
table = Table
field = Field
range = Range

[dic.de]
topics = Themen
topic = Thema
table = Tabelle
field = Feld
range = Bereich

[vars]
qid = dropbox
parm = ref
type = button
width = 125
icon = core/icons/other/book.gif
current = ???

tspace = 0
bspace = 3

[default]
<!VAR:items!>

# ***********************************************************
# common parts
# ***********************************************************
[content]
<div class="dropdown-content">
	<!VAR:links!>
</div>

[link]
<div><a href="?<!VAR:parm!>=<!VAR:value!>"><!VAR:caption!></a></div>

# ***********************************************************
[table]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<table class="navi">
<!VAR:items!>
</table>
</div>

[table.box]
<tr>
	<td class="selHead" width=<!VAR:width!>><!VAR:uniq!></td>
	<td class="selData">
		<div class="dropdown">
			<button class="dropdown-button"><!VAR:current!>&nbsp;&nbsp;&nbsp;▾</button>
<!SEC:content!>
		</div>
	</td>
</tr>

[table.one]
<tr>
	<td width=<!VAR:width!>><!VAR:uniq!></td>
	<td><button class="dropdown-button"><!VAR:current!></button></td>
</tr>

[table.text]
<tr>
	<td colspan="100%" class="nopad">
<form method="post" action="?">
	<table class="navi">
		<tr height="0">
			<td class="selHead" width="125"><!VAR:uniq!></td>
			<td class="selData">
				<input type="text" name="<!VAR:parm!>" value="<!VAR:value!>" size="25"> &nbsp;
				<input type="submit" name="drop.act" value="OK">
			</td>
		</tr>
	</table>
</form>
	</td>
</tr>

# ***********************************************************
[combo]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<!VAR:items!>
</div>

[combo.box]
<div class="dropdown">
	<button class="dropdown-button"><!VAR:current!>&nbsp;&nbsp;&nbsp;▾</button>
<!SEC:content!>
</div>

[combo.one]
<button><!VAR:current!></button>

# ***********************************************************
[inline]
# ***********************************************************
<!VAR:items!>

[inline.box]
<div class="dropdown">
	<button class="dropdown-button"><!VAR:current!>&nbsp;&nbsp;&nbsp;▾</button>
<!SEC:content!>
</div>

[inline.one]
<button><!VAR:current!></button>

# ***********************************************************
[menu] # multiple options with title
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
	<div class="localmenu">
<!VAR:items!>
	</div>
</div>

[menu.box]
&nbsp; <!VAR:uniq!>:
<div class="dropdown">
	<span class="dd-text"><!VAR:current!>&nbsp; ▾</span>
<!SEC:content!>
</div>

[menu.one]
&nbsp; <!VAR:uniq!>:
<span class="dd-text"><!VAR:current!></span>

# ***********************************************************
[beam] # single option without title
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
	<div class="localmenu">
<!VAR:items!>
	</div>
</div>

[beam.box]
<div class="dropdown">
	<span class="dd-text"><!DIC:range!>&nbsp; ▾</span>
<!SEC:content!>
</div>

[beam.one]
<span class="dd-text"><!DIC:range!></span>

# ***********************************************************
[icon]
# ***********************************************************
<!VAR:items!>

[icon.box]
<div class="dropdown">
	<button class="dropdown-button">
		<img src="<!VAR:icon!>" /> &nbsp; ▾
	</button>
<!SEC:content!>
</div>

[icon.one]
<div class="dropdown">
	<button class="dropdown-button dropdown-beam"><!VAR:current!></button>
</div>

# ***********************************************************
[topic]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<table class="navi" width="100%">
	<tr>
		<td class="nopad" width="*">
			<div class="localmenu">
				<!VAR:items!>
			</div>
		</td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=26 align="center">
			<div class="localmenu">
				<a style="color: white; vertical-align: top; font-family: monospace;" href="?vmode=topics">?</a>
			</div>
		</td>
	</tr>
</table>
</div>

[topic.box]
<div class="dropdown">
	<span style="padding: 5px 0px 0px 7px;"><!DIC:topics!>&nbsp; ▾</span>
<!SEC:content!>
</div>

[topic.one]
<span style="padding: 5px 0px 0px 7px;"><!DIC:topic!></span>

# ***********************************************************
[js.button]
# ***********************************************************
<!VAR:items!>

[js.button.box]
<div class="dropdown">
	<span class="dd-text"><!VAR:current!>&nbsp; ▾</span>
<!SEC:content!>
</div>

[js.button.one]
<button><!VAR:current!></button>
