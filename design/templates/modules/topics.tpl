[dic]
info = Select a topic
nofile = No description available ...

[dic.de]
info = Wähle ein Thema ...
nofile = Keine Beschreibung vorhanden ...


[main]
<h3><!VAR:title!></h3>
<!SEC:hint!>

<!VAR:topics!>

[hint]
<p><!DIC:info!></p>

[topic]
<topic>
	<a href='?tpc=<!VAR:tab!>'>
		<topichead><!VAR:caption!></topichead>
		<topicdesc>
			<!VAR:info!>
		</topicdesc>
	</a>
</topic>

[topic.notext]
<topic>
	<a href='?tpc=<!VAR:tab!>'>
		<topichead><!VAR:caption!></topichead>
	</a>
</topic>

[items]
<!VAR:items!>

[item]
<div>
	<a href=?tpc=<!VAR:tab!>><!VAR:title!></a>
</div>

[nofile]
<p><!DIC:nofile!></p>


