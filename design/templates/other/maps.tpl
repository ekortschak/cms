[vars]
wid = 600
hgt = 450
len = 46.9514
lat = 14.4116
zoom = 14

[main]
<iframe width="<!VAR:wid!>" height="<!VAR:hgt!>" Loading="lazy" allowfullscreen <!SEC:src!>></iframe> 

[key]
key=

[src]
<!SEC:location!>

[parms]
<!SEC:key!>&zoom=<!VAR:zoom!>&center=<!VAR:len!>,<!VAR:lat!>&q=<!VAR:len!>,<!VAR:lat!>

# ***********************************************************
# code snips
# ***********************************************************
[place]
src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJ59NS2J5GcEcRrXJQ43NF0kM&<!SEC:key!>"

[location.embed]
src="https://www.google.com/maps/embed/v1/view?<!SEC:key!>&zoom=<!VAR:zoom!>&center=<!VAR:len!>,<!VAR:lat!>"

[location]
src="https://maps.google.com/?zoom=<!VAR:zoom!>&q=<!VAR:len!>,<!VAR:lat!>"

[check]
<iframe width="600" height="450" style="Border:0" Loading="lazy"allowfullscreen 
src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJ59NS2J5GcEcRrXJQ43NF0kM&<!SEC:key!>">
</iframe> 

# ***********************************************************
# no embedding
# ***********************************************************
[noapi]
<p><a href="https://maps.google.com/?q=<!VAR:len!>,<!VAR:lat!>" target="gm">Meine aktuelle Position</a></p>
