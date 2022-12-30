[include]
LOC_TPL/modules/fview.gallery.tpl

[dic]
inis = Create ini file(s)
uids = Check UIDs

all = all
select = Select file(s)
sibling = Add a sibling
addfile = Create a new file

[dic.de]
inis = Ini-Datei(en) erstellen
uids = UIDs überprüfen

all = Alle
select = Datei(en) wählen
sibling = Eintrag erstellen
addfile = Datei erstellen


# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
	<input type="hidden" name="opt_act" value="upload" />

<!SEC:addNode!>
<!SEC:perms!>
</form>

<h4><!DIC:head!></h4>
<!SEC:files!>

<form method="post" action="?" enctype="multipart/form-data">
<!SEC:append!>
</form>
