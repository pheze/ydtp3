~:extend('base')~
~[content]~

~ if ($match == null) { ~
    Match inconnu.
 ~} else {~
    <h3>~~$match->description~</h3>
    Date: ~~$match->date~ <br>
    Arena: ~~$match->getArena()->nom~ <br>
    Place disponible: ~~$match->places~/~~$match->getArena()->sieges~ <br>
    Prix: ~~$match->prix~

    ~if ($is_logged) { ~
        <br><br>
        Achat de billet? 
            <form action="index.php">
            <input type="hidden" name="section" value="confirmation_achat_billet">
            <input type="hidden" name="match_id" value="~~$match->id~">
            <input type="text" name='nombre_billet'></input>
            <input type="submit" value="confirmer"></input>
        </form>
    ~}~

 ~}~

~[/content]~
