<?php
function randomColor ($minVal = 0, $maxVal = 255)
{

  // Make sure the parameters will result in valid colours
  $minVal = $minVal < 0 || $minVal > 255 ? 0 : $minVal;
  $maxVal = $maxVal < 0 || $maxVal > 255 ? 255 : $maxVal;

  // Generate 3 values
  $r = mt_rand($minVal, $maxVal);
  $g = mt_rand($minVal, $maxVal);
  $b = mt_rand($minVal, $maxVal);

  // Return a hex colour ID string
  return sprintf('%02X%02X%02X', $r, $g, $b);

}
?>
