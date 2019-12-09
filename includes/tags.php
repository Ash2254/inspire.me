<?php 
foreach($tags as $tag) {
$output = "<a href=\"#\" class=\"badge badge-pill badge-";

switch ($tag) {
    case 'Web Developer':
    $output .= "info\">";
    break;
    
    case 'Graphic Designer':
    $output .= "warning\">";
    break;
    default:
    $output .= "primary\">";
    break;
}

$output .= $tag."</a> ";

echo $output;
}
?>