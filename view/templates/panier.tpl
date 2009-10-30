~:extend('base')~
~[content]~
~ if (!$is_logged) { ~
    Vous devez vous identifier afin d'utiliser le panier.
~ } else if (empty($reservations)) { ~
    Il n'y a rien dans le panier.
    ~ } else { ~

    <table class="reservations">
    <tr>
        <td>Effacer</td>
        <td>Description</td>
        <td>Siege</td>
	<td>Rangée</td>
        <td>Date</td>
        <td>Aréna</td>
    </tr>
~ $color_counter = 0; ~    
~ $colors = array('dark','light'); ~
   ~ foreach ($reservations as $x) { ~
    <tr class='~~$colors[$color_counter % 2]~'>
      <td>
        <form type="get" action="index.php">
            <input type="hidden" name="reservation_id" value="~~$x->id~"></input>
            <input type="hidden" name="section" value="panier"></input>
            <input type="submit" value="X" />
        </form>
      </td>
      <td>~~$x->get_match()->description~</td>
      <td>~~$x->siege~</td> 
      <td>~~$x->rangee~</td> 
      <td>~~$x->get_match()->date~</td> 
      <td>~~$x->get_match()->getArena()->nom~</td>
    </tr>

      ~ $color_counter++; ~
    ~ } ~
   </table>
  
   Coût total: ~~$cout_total~
   <br><br> 
   <form type="get" action="index.php">
        <input type="hidden" name="section" value="achat_billet"></input>
        <input type="submit" value="Acheter les billets" />
   </form>
   <br>
   <form type="get" action="index.php">
        <input type="hidden" name="tout_effacer" value="true"></input>
        <input type="hidden" name="section" value="panier"></input>
        <input type="submit" value="Tout effacer" />
   </form>
~ } ~

~[/content]~
