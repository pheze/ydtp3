~:extend('base')~
~[content]~
~ if (empty($matches)) { ~
 Il n'y a aucun match.
~ } else { ~
 <table class="matches">
    <tr>
        <td>Description</td>
        <td>Date</td>
        <td>Arena</td>
        <td>Prix</td>
        <td>Places</td>
    </tr>
~ $color_counter = 0; ~
~ $colors = array('dark','light'); ~
~ foreach ($matches as $x) { ~
    <tr class='~~$colors[$color_counter % 2]~'>
        <td>
            <a href="index.php?section=match_detail&id=~~$x->id~">~~$x->description~</a>
        </td>

~ $arena = $x->getArena(); ~
        <td>~~$x->date~</td>
        <td>~~$arena->nom~</td>
        <td>~~$x->prix~</td>
        <td>~~(int)$arena->largeur * (int)$arena->profondeur~</td>
    </tr>
    ~$color_counter++;~
~ } ~
 </table>
~ } ~
~[/content]~
