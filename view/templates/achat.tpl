~:extend('base')~
~[content]~
    ~ if (!$is_logged) { ~
        Vous devez être identifié pour voir l'historique de vos achats.
    ~ } else if (empty($achats)) { ~
        Aucun achat effectué.
    ~ } else { ~
        
        <table border=1>
        <tr>
            <td>Description</td>
            <td>Date</td>
            <td>Quantite</td>
        </tr>
        
        ~ foreach ($achats as $achat) { ~
            <tr>
                <td>~~$achat->get_match()->description~</td>
                <td>~~$achat->get_match()->date~</td>
                <td>~~$achat->qte~</td>
            </tr>
        ~ } ~

        </table>
    ~ } ~
~[/content]~
