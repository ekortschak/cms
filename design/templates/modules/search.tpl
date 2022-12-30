[dic]
search = Search
result = Search results
sinfo  = Search text
short  = Search text<br><small>&ensp; &rarr; min. 2 characters</small>
empty  = Search returned no results
nosel  = Select an entry from the result list
prevw  = Preview
stop   = Stop search
show   = Show

[dic.de]
search = Suche
result = Suchergebnisse
sinfo  = Suchtext
short  = Suchtext<br><small>&ensp; &rarr; min. 2 Buchstaben</small>
empty  = Suche ergab keine Treffer
nosel  = Wähle einen Eintrag aus der Ergebnisliste
prevw  = Vorschau
stop   = Suche beenden
show   = Zeige

[vars]
search =
result =


# ***********************************************************
[main]
# ***********************************************************
<!SEC:nav.toc!>

<div style="margin: -15px 0px 12px;">
	<h3><!DIC:search!></h3>
</div>

<form method="post" action="?">
<!VAR:range!>

	<input type="text" name="search" value="<!VAR:search!>" placeholder="<!DIC:sinfo!>" style="width: calc(100% - 12px);" />

	<div align="right">
		<input type="submit" name="search,act" value="OK" />
	</div>
</form>

<h4><!DIC:result!></h4>
<!VAR:result!>

# ***********************************************************
[result]
# ***********************************************************
<!VAR:items!>

[topic]
<div style="white-space: nowrap;"><h5><!VAR:topic!></h5></div>

[item]
<div style="white-space: nowrap;"><a href="?dir=<!VAR:tab!>&prv=<!VAR:key!>"><!VAR:title!></a></div>

[nav.toc]
<div style="float: right;">
	<a href="?vmode=view"><button class="icon"><img src="core/icons/buttons/view.png" align="right" /></button></a>
</div>

[nav.preview]
<div style="float: right;">
	<a href="?vmode=view&tpc=<!VAR:topic!>&pge=<!VAR:page!>">
		<button class="icon"><img src="core/icons/buttons/view.png" alt="View"></button>
	</a>
</div>

<!SEC:nav.info!>

# ***********************************************************
[preview]
# ***********************************************************
<h3><!DIC:prevw!></h3>


[nav.info]
<!SEC:preview!>
<div class="localmenu"><!VAR:title!></div>
#<hint>dir = <!VAR:dir!></hint></p>

[err.empty]
<!SEC:preview!>
<div><!DIC:empty!></div>

[err.nosel]
<!SEC:preview!>
<div><!DIC:nosel!></div>

[err.short]
<div><!DIC:short!></div>

# ***********************************************************
[none]
# ***********************************************************
<h3>Info</h3>
<ul>
	<li>Enter a search term into the text field.</li>
	<li>Click OK.</li>
	<li>Select an item from the results list.</li>
</ul>

<h4>How to use</h4>
<table>
	<tr class="rh"><th></th>                 <th>Pattern</th>                  <th></th><th>will find any text containing ...</th></tr>
	<tr class="rw"><td align="center">+</td> <td class="pre">+str or str</td>  <td></td><td>any occurrence of str</td></tr>
	<tr class="rw"><td align="center">-</td> <td class="pre">-str</td>         <td></td><td>anything but str</td></tr>
	<tr class="rw"><td align="center">+</td> <td class="pre"> str1 str2</td>   <td></td><td>all of these strings</td></tr>
	<tr class="rw"><td align="center">|</td> <td class="pre"> str1|str2</td>   <td></td><td>any of these strings (no blanks!)</td></tr>
	<tr class="rw"><td align="center">-|</td><td class="pre">-str1|str2</td>   <td></td><td>none of these strings (no blanks!)</td></tr>
	<tr class="rw"><td align="center">^</td> <td class="pre">^str or Str</td>  <td></td><td>any string beginning with str</td></tr>
	<tr class="rw"><td align="center">^</td> <td class="pre"> str^</td>        <td></td><td>any string ending with str</td></tr>
	<tr class="rw"><td align="center">^</td> <td class="pre">^str^ or Str^</td><td></td><td>the exact word</td></tr>
	<tr class="rw"><td align="center">""</td><td class="pre">"str1 str2"</td>  <td></td><td>the exact character sequence</td></tr>
</table>

[none.de]
<h3>Info</h3>
<ul>
	<li>Gib einen Suchbegriff in das Textfeld ein.</li>
	<li>Drücke OK.</li>
	<li>Wähle einen Eintrag in der Ergebnisliste.</li>
</ul>

<h4>Verwendungshinweis</h4>
<table>
	<tr class="rh"><th></th>                 <th>Muster</th>                   <th></th><th>findet Textstellen ...</th></tr>
	<tr class="rw"><td align="center">+</td> <td class="pre">+str bzw. str</td><td></td><td>die str beinhalten</td></tr>
	<tr class="rw"><td align="center">-</td> <td class="pre">-str</td>         <td></td><td>die str nicht beinhalten</td></tr>
	<tr class="rw"><td align="center">+</td> <td class="pre"> str1 str2</td>   <td></td><td>mit allen angegebenen Zeichenketten</td></tr>
	<tr class="rw"><td align="center">|</td> <td class="pre"> str1|str2</td>   <td></td><td>mit zumindest einer der Zeichenketten (keine Leerzeichen!)</td></tr>
	<tr class="rw"><td align="center">-|</td><td class="pre">-str1|str2</td>   <td></td><td>ohne die angegebenen Zeichenketten (keine Leerzeichen!)</td></tr>
	<tr class="rw"><td align="center">^</td> <td class="pre">^str bzw. Str</td><td></td><td>in denen Wörter mit str beginnen</td></tr>
	<tr class="rw"><td align="center">^</td> <td class="pre"> str^</td>        <td></td><td>in denen Wörter mit str enden</td></tr>
	<tr class="rw"><td align="center">^</td> <td class="pre">^str^ bzw. Str^</td><td></td><td>in denen das angegebene Wort vorkommt</td></tr>
	<tr class="rw"><td align="center">""</td><td class="pre">"str1 str2"</td>  <td></td><td>in denen die angegebene Wortfolge vorkommt</td></tr>
</table>
