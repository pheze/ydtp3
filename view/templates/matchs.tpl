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
        <td>~~$x->date~</td>
        <td>~~$x->getArena()->nom~</td>
        <td>~~$x->prix~</td>
        <td>~~$x->places~</td>
    </tr>
    ~$color_counter++;~
~ } ~
 </table>
~ } ~
~[/content]~
