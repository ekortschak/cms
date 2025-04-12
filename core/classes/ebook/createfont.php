<?php

// convert TTF font to TCPDF format and store it on the fonts folder
$fdr = "/usr/share/fonts/truetype/liberation";

TCPDF_FONTS::addTTFfont('$fdr/LiberationSans-Regular.ttf');
