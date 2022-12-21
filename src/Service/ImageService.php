<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Trick;

class ImageService
{

    public function add(array $images, Trick $trick, $directory)
    {
        // On boucle sur les images
        foreach($images as $image){
        // On génère un nouveau nom de fichier
        $fichier = md5(uniqid()).'.'.$image->guessExtension();
        
        // On copie le fichier dans le dossier uploads
        $image->move(
            $directory,
            $fichier
        );
        
        // On crée l'image dans la base de données
        $img = new Image();
        $img->setTitle($fichier);
        $trick->addImage($img);
         }
    }

}