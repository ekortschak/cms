[include]
LOC_TPL/menus/buttons.tpl

[dic]
paragraph = Paragraph
head1 = Heading 1
head2 = Heading 2
head3 = Heading 3
head4 = Heading 4
head5 = Heading 5
head6 = Heading 6
pbreak = Page break
sbreak = Soft hyphen
hrule = Horizontale Linie
elision = [...]

quote = Quote
key = Key
dfn = Definition
hilite = Markup
hint = Hint
small = Small print

listings = Listings
listnum = Listings with &num;
listbul = Listings with &bull;
listdef = Definitions

table = Table
trow = Table Row
tcell = Table Cell
askCols = Set columns

linkdef = Link into same window
linknew = Link into new window

img = Image (originial size)
imgfull = Picture (page width)
imgleft = Thumb left
imgright = Thumb right
askWidth = Set thumb width

[dic.de]
paragraph = Absatz
head1 = Überschrift 1
head2 = Überschrift 2
head3 = Überschrift 3
head4 = Überschrift 4
head5 = Überschrift 5
head6 = Überschrift 6
pbreak = Seitenumbruch
sbreak = Bedingter Trennstrich
hrule = Horizontale Linie
elision = [...]

quote = Zitat
key = Taste
dfn = Definition
hilite = Wichtig
hint = Anmerkung
small = Kleindruck

table = Tabelle einfügen
trow = Zeile einfügen
tcell = Zelle einfügen
askCols = Spalten festlegen

listings = Listen
listnum = Numerierte Liste (&num;)
listbul = Aufzählung (&bull;)
listdef = Definitionen

linkdef = Link ins aktuelle Fenster
linknew = Link in neues Fenster

img = Bild (Originalgröße)
imgfull = Bild (Seitenbreite)
imgleft = Vorschaubild links
imgright = Vorschaubild rechts
askWidth = Bildbreite festlegen


[edit]
<button class="icon" onclick="doUndo();"><img src="ICONS/edit/undo.png" /></button>
&nbsp;

# *****************************************************************
# formatting tasks
# *****************************************************************
[formatting]
<div class="dropdown"><button class="icon rose" onclick="addTag('p');">¶COMBO_DOWN</button>
	<div id="edHead" class="dropdown-content">
		<div><a href="javascript:addTag('p');"><p><!DIC:paragraph!></p></a></div>
		<hr>
		<div><a href="javascript:addTag('h1');"><h1><!DIC:head1!></h1></a></div>
		<div><a href="javascript:addTag('h2');"><h2><!DIC:head2!></h2></a></div>
		<div><a href="javascript:addTag('h3');"><h3><!DIC:head3!></h3></a></div>
		<div><a href="javascript:addTag('h4');"><h4><!DIC:head4!></h4></a></div>
		<div><a href="javascript:addTag('h5');"><h5><!DIC:head5!></h5></a></div>
		<div><a href="javascript:addTag('h6');"><h6><!DIC:head6!></h6></a></div>
		<hr>
		<div><a href="javascript:addTag('blockquote');"><blockquote><!DIC:quote!></blockquote></a></div>
	</div>
</div>

# *****************************************************************
# listings & tables
# *****************************************************************
<div class="dropdown"><button class="icon rose"><img src="ICONS/buttons/listing.png" />COMBO_DOWN</button>
	<div id="edList" class="dropdown-content">
		<div><a href="javascript:addList('ul');"><!DIC:listbul!></a></div>
		<div><a href="javascript:addList('ol');"><!DIC:listnum!></a></div>
		<div><hr class="low" /></div>
		<div><a href="javascript:addList('dl');"><!DIC:listdef!></a></div>
	</div>
</div>
<div class="dropdown"><button class="icon rose"><img src="ICONS/buttons/table.png" />COMBO_DOWN</button>
	<div id="tables" class="dropdown-content">
		<div><a href="javascript:askCols();"><!DIC:askCols!></a></div>
		<div><a href="javascript:addTable('tb');"><!DIC:table!></a></div>
		<div><a href="javascript:addTable('tr');"><red><!DIC:trow!></red></a></div>
		<div><a href="javascript:addTable('td');"><red><!DIC:tcell!></red></a></div>
	</div>
</div>

[addImg]
<div class="dropdown">
	<button class="icon rose"><img src="ICONS/buttons/img.png" />COMBO_DOWN</button>

	<div id="edImg" class="dropdown-content">
		<div><a href="javascript:insImg('ico');"><!DIC:img!></a></div>
		<div><a href="javascript:insImg('img');"><!DIC:imgfull!></a></div>
		<hr>
		<div><a href="javascript:askWid();"><!DIC:askWidth!></a></div>
		<hr>
		<div><a href="javascript:insImg('il');"><!DIC:imgleft!></a></div>
		<div><a href="javascript:insImg('ir');"><!DIC:imgright!></a></div>
	</div>
</div>

# *****************************************************************
[characters]
# *****************************************************************
<div class="dropdown"><button class="icon" onclick="addTag('b');"><b>B</b>COMBO_DOWN</button>
	<div id="edChar" class="dropdown-content">
		<button class="icon" onclick="addTag('b');"><b>B</b></button>
		<button class="icon" onclick="addTag('i');"><i>I</i></button>
		<button class="icon" onclick="addTag('u');"><u>U</u></button>
		<button class="icon" onclick="addTag('kap');"><kap>Caps</kap></button>
		<button class="icon" onclick="addTag('sup');">x<sup>2</sup></button>
		<button class="icon" onclick="addTag('sub');">x<sub>2</sub></button>
		<br>
		<button class="icon" onclick="addTag('red');"><red><b>X</b></red></button>
		<button class="icon" onclick="addTag('maroon');"><maroon><b>X</b></maroon></button>
		<button class="icon" onclick="addTag('blue');"><blue><b>X</b></blue></button>
		<button class="icon" onclick="addTag('green');"><green><b>X</b></green></button>
		<button class="icon" onclick="addTag('white');"><white><b>X</b></white></button>
		<button class="icon" onclick="addTag('grey');"><grey><b>X</b></grey></button>
		<button class="icon" onclick="addTag('dark');"><dark><b>X</b></dark></button>
		<button class="icon" onclick="addTag('black');"><black><b>X</b></black></button>
		<hr>
		<div><a href="javascript:addTag('mark');">  <mark><!DIC:hilite!></mark> </a></div>
		<div><a href="javascript:addTag('kbd');">   <kbd><!DIC:key!></kbd>      </a></div>
		<div><a href="javascript:addTag('dfn');">   <dfn><!DIC:dfn!></dfn>      </a></div>
		<div><a href="javascript:addTag('hint');">  <hint><!DIC:hint!></hint>   </a></div>
		<div><a href="javascript:addTag('small');"> <small><!DIC:small!></small></a></div>
	</div>
</div>

<button class="icon" onclick="clrTags();"><img src="ICONS/edit/clear.png" /></button>

[addLFs]
<div class="dropdown"><button class="icon" onclick="insAny('<br>');">&crarr;COMBO_DOWN</button>
	<div id="edLFs" class="dropdown-content">
		<div><a href="javascript:insAny('<br>');">&crarr;</a></div>
		<div><a href="javascript:insAny('\n<hr>\n');"><!DIC:hrule!></a></div>
		<div><a href="javascript:insAny('\n<hr class=\'pbr\'>\n');"><!DIC:pbreak!></a></div>
		<div><a href="javascript:insAny('&shy;');"><!DIC:sbreak!></a></div>
		<div><a href="javascript:repAny('[...] ');"><!DIC:elision!></a></div>
	</div>
</div>


# *****************************************************************
# tags with parameters
# *****************************************************************
[addLink]
<div class="dropdown">
	<button class="icon">🔗COMBO_DOWN</button>

	<div id="edLink" class="dropdown-content">
		<div><a href="javascript:insRef('ax');"><!DIC:linknew!></a></div>
		<div><a href="javascript:insRef('aa');"><!DIC:linkdef!></a></div>
	</div>
</div>

<!VAR:snips!>

# *****************************************************************
[switch.htm]
# *****************************************************************
<td align="center">
	<button class="icon" onclick="toggleView();">
		<img src="ICONS/buttons/edit.toggle.png" alt="Toggle Editor" />
	</button>
</td>
