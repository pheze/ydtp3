~:extend('base')~
~[content]~
        ~ if (!$ok) { ~
            Une erreur s'est produite lors de l'achat des billets. :( 
        ~ } else { ~
            <br>Vos billets sont achetés. 
        ~ } ~

        <br><br>
        <a href="index.php?section=matchs">Retour aux matchs</a>
~[/content]~
