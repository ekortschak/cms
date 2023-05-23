[dic]
head = Quick edit options
remove = Remove pagebreaks in file

[dic.de]
head = Schnelländerungen

# ***********************************************************
[info]
# ***********************************************************
<h4>Merge pages into single file</h4>

<p>This feature allows you to merge all files in the selected branch into one single html-file which you may use to get a hardcopy or booklet from your project files. Just use "Print to pdf" form your browser's menu.</p>

[info.de]
<h4>Seiten zusammenführen</h4>

<p>Diese Funktion erlaubt die Zusammenführung aller Seiten im ausgewählten Menüzweig in eine einzige Datei, die dann über den Befehl "An PDF drucken" im Browser-Menü als PDF für den Druck z.B. als Buch verwendet werden kann.</p>


# ***********************************************************
[main]
# ***********************************************************
<section style='clear: both;'>
<!VAR:head!>
<!VAR:pic!>
<!VAR:title!>
<!VAR:text!>
<!VAR:foot!>
</section>

# ***********************************************************
[pic]
# ***********************************************************
<img src='<!VAR:pic!>', align='right' width=198 style='margin: 0px 0px 5px 10px;' />

[fnote]
<div><fnote><!VAR:idx!></fnote> <b><!VAR:key!></b><br><!VAR:val!></div>
