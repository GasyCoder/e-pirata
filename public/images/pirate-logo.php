<?php
// Créer une image de 200x200 pixels
$image = imagecreatetruecolor(200, 200);

// Activer la transparence
imagealphablending($image, true);
imagesavealpha($image, true);

// Couleurs
$transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
$black = imagecolorallocate($image, 0, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255);

// Remplir le fond avec de la transparence
imagefill($image, 0, 0, $transparent);

// Dessiner le crâne principal (blanc)
imagefilledellipse($image, 100, 100, 80, 80, $white);

// Dessiner le chapeau de pirate (noir)
imagefilledrectangle($image, 40, 40, 160, 80, $black);
imagefilledrectangle($image, 60, 20, 140, 40, $black);

// Yeux (noir)
imagefilledellipse($image, 80, 90, 20, 20, $black);
imagefilledellipse($image, 120, 90, 20, 20, $black);

// Bouche (noir)
imagefilledarc($image, 100, 120, 60, 40, 0, 180, $black, IMG_ARC_PIE);

// Sauvegarder l'image
imagepng($image, __DIR__ . '/pirate-logo.png');
imagedestroy($image);
?>
