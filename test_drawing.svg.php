<?php
header( "Content-type: image/svg+xml" );
print ( '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' ) ;
$color = key_exists( "color", $_GET ) ? $_GET[ "color" ] : "#000000";
$height = key_exists( "height", $_GET ) ? $_GET[ "height" ] : "980";
$width = key_exists( "width", $_GET ) ? $_GET[ "width" ] : "860";
?>
<svg xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:cc="http://creativecommons.org/ns#"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:svg="http://www.w3.org/2000/svg"
    xmlns="http://www.w3.org/2000/svg" version="1.1" width="<?php echo $width;?>"
    height="<?php echo $height;?>" id="svg2">
  <defs id="defs4" />
  <metadata id="metadata7">
    <rdf:RDF>
      <cc:Work rdf:about="">
        <dc:format>image/svg+xml</dc:format>
        <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
        <dc:title></dc:title>
      </cc:Work>
    </rdf:RDF>
  </metadata>
  <g transform="translate(0,-72.36217)" id="layer1">
    <rect width="337.3118" height="443.30573" x="152.48698"
        y="611.99823" id="rect2985"
        style="fill:<?php echo $color;?>;fill-rule:evenodd;stroke:<?php echo $color;?>;stroke-width:1.05085814px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
    <rect width="662.85712" height="51.42857" ry="25.714285"
        x="1.1428566" y="566.64789" id="rect3031" style="fill:<?php echo $color;?>" />
    <rect width="71.428574" height="511.86438" ry="0" x="568.57141"
        y="286.78348" id="rect3033" style="fill:<?php echo $color;?>" />
    <rect width="70.071793" height="304.98618" ry="0" x="608.26398"
        y="-204.23988"
        transform="matrix(0.68725895,0.72641251,-0.72641251,0.68725895,0,0)"
        id="rect3033-1" style="fill:<?php echo $color;?>" />
    <rect width="70.071793" height="304.98618" ry="0" x="-220.16168"
        y="671.38165"
        transform="matrix(-0.68725895,0.72641251,0.72641251,0.68725895,0,0)"
        id="rect3075" style="fill:<?php echo $color;?>" />
    <path
        d="m 592.95954,824.71301 a 110.6117,110.6117 0 1 1 -221.2234,0 110.6117,110.6117 0 1 1 221.2234,0 z"
        transform="translate(118.18785,-632.57696)" id="path3077"
        style="fill:<?php echo $color;?>" />
  </g>
</svg>