~:extend('base')~
~[content]~
        ~ if (!$ok && !$full) { ~
            Une erreur s'est produite lors de l'achat des billets. :( 
        ~ } else if (!$ok && $full) { ~
            Impossible d'effectuer l'achat car il n'y a plus de places disponibles. 
        ~ } else { ~
            <br>Vos billets sont maintenant réservés. <br> 
            <br><a href="index.php?section=panier">Voir le panier d'achat</a><br>
        ~ } ~

        <a href="index.php?section=matchs">Retour aux matchs</a>
~[/content]~
