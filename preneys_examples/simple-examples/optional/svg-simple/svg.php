<?php
// NOTE: SVG can be loaded as an image in HTML with with <img>, e.g.,
//   <img src="path/to/something.php" />
// etc.

// This file demonstrates hacking SVG output from PHP...

header('Content-Type: image/svg+xml');

function gen_header($width='100%',$height='100%',$jsFiles=array())
{
  echo <<<ZZEOF
<?xml version="1.0" ?>
<svg
  id="svgRoot"
  version="1.1"
  xmlns="http://www.w3.org/2000/svg"
  xmlns:xlink="http://www.w3.org/1999/xlink"
  width="${width}" height="${height}"
  preserveAspectRatio="xMidYMid meet"
>
ZZEOF;

foreach ($jsFiles as $j)
  echo "<script xlink:href='${j}' type='text/javascript' />";
}

function gen_footer()
{
  echo "</svg>";
}

//******************************************************

gen_header(
  '100%','100%'
  //,array('drag-and-drop-code.js')
);

$stroke_color = '#FF0';
$stroke_width = '5px';

?>
  <!-- clipPath is a "cookie cutter" that will cut the image with the shape(s)
        described below. -->
  <clipPath id="use-star-clip-path">
    <path
      id="use-star-clip-path-shape"
      d="M50,97 64.6946,70.2254 94.6997,64.5238 73.7764,42.2746 77.6259,11.9762 50,25 22.3741,11.9762 26.2236,42.2746 5.30034,64.5238 35.3054,70.2254 Z" transform="rotate(180 50 50)"
    />
  </clipPath>

  <!-- Specify the shape (in this case an image) that we want to cut with a
        clipPath shape... -->
  <image
    xlink:href="max.jpg" clip-path="url(#use-star-clip-path)"
    width="100" height="100"
  />

  <!-- We need the ability to apply a stroke with no fill, so we
        <use> our path. -->
  <use
    xlink:href="#use-star-clip-path-shape"
    fill="none"
    stroke='<?php echo $stroke_color; ?>'
    stroke-width='<?php echo $stroke_width; ?>'
  />
<?php
gen_footer();
?>
