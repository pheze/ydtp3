~:extend('base')~
~[content]~

~ if (!$ok) { ~
Erreur lors de l'achat des billets.
~ } else if (!$ok_place) { ~
Désolé, il n'y a pas assez de place pour satisfaire votre demande. 
~ } else { ~

~ $str = 'un billet'; ~
~ if ($nombre_billet > 1) { $str = 'ces billets'; } ~ 
Êtes-vous certain de vouloir ajouter ~~$str~ au panier ?
<a href="index.php?section=reservation_billet&nombre_billet=~~$nombre_billet~&match_id=~~$match_id~">oui</a> 
<a href="index.php?section=match_detail&id=~~$match_id~">non</a>

~ } ~
~[/content]~
