<?php 
$SWvalues = array(
"x0\.25" => "radial-gradient(circle,
    rgba(34,255,0,1) 7%,
    rgba(50,200,41,1) 21%,
    rgba(53,201,24,1) 48%,
    rgba(67,240,23,1) 64%,
    rgba(13,200,3,1) 90%)",
"x0\.5" => "radial-gradient(circle,
    rgba(157,252,142,1) 7%,
    rgba(138,231,132,1) 21%,
    rgba(115,194,99,1) 48%,
    rgba(129,237,101,1) 64%,
    rgba(125,196,121,1) 90%)",
"x0" => "radial-gradient(circle,
    rgba(142,142,142,1) 7%,
    rgba(184,184,184,1) 21%,
    rgba(133,128,128,1) 48%,
    rgba(181,178,178,1) 64%,
    rgba(94,94,94,1) 90%)",
"x1" => "radial-gradient(circle,
    rgba(255,218,89,1) 7%,
    rgba(210,160,82,1) 21%,
    rgba(246,208,64,1) 48%,
    rgba(213,172,70,1) 64%,
    rgba(255,198,51,1) 90%)",
"x2" => "radial-gradient(circle,
    rgba(255,119,119,1) 7%,
    rgba(193,88,88,1) 21%,
    rgba(232,106,106,1) 48%, 
    rgba(207,69,69,1) 64%,
    rgba(255,93,93,1) 90%)",
"x4" => "radial-gradient(circle
    rgba(193,31,31,1) 7%,
    rgba(207,81,81,1) 21%,
    rgba(193,16,16,1) 48%,
    rgba(237,12,12,1) 64%,
    rgba(157,2,2,1) 90%)"
);

header("Content-type: text/css; charset: UTF-8"); 

$keys = array_keys((array)$SWvalues);
for ($i = 0; $i <count($SWvalues) ; $i++) {
    echo "." . $keys[$i] . "{background: " . $SWvalues[$keys[$i]] . ";}\n\n";
   }
?>
