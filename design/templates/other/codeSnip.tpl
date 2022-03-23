[vars]
caption = Test
info = Any description ...
heado = Sample Output
headc = Sample Code

[main]
<!SEC:output!> <br>
<!SEC:code!>


[output]
<div class="tuthed"><!VAR:heado!></div>
<div class="tutinf"><!VAR:output!></div>

[code]
<div class="tuthed"><!VAR:headc!></div>
<div class="tutinf"><!VAR:code!></div>

[pic]
<div class="tuthed"><!VAR:heado!></div>
<div class="tutinf"><img width="100%" src="<!VAR:file!>" /></div>

