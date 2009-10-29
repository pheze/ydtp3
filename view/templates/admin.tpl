~:extend('base')~
~[content]~
~ if (!$is_logged || !$is_admin) { ~
Vous n'êtes pas administrateur.
~ } else { ~
    <a href="index.php?section=admin_arenas">Configurer les arenas</a><br>
    <a href="index.php?section=admin_matches">Configurer les matches</a>
~ } ~
~[/content]~
