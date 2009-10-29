~:extend('base')~
~[content]~
~ if (!$is_logged || !$is_admin) { ~
Vous n'êtes pas administrateur.
~ } else { ~
    <p><a href="index.php?section=admin">Back to admin</a></p>
    Arenas:<br>

    <table>

    <form action="index.php" method="post">
    ~ $counter = 0; ~
       <tr>
          <th>nom</th>
          <th>sieges</th>
          <th>effacer</th>
        </tr>
     ~ foreach ($arenas as $arena) { ~
       <tr>
            <td><input type="text" name="nom~~$counter~" value="~~$arena->nom~" /></td>
            <td><input type="text" size="5" name="sieges~~$counter~" value="~~$arena->sieges~" /></td>
            <td><input type="checkbox" name="delete~~$counter~" /></td>
        </tr>

        ~ $counter++; ~
    ~ } ~

      <tr><td /><td /><td /></tr>
      <tr>
           <input type="hidden" name="section" value="admin_arenas" />
           <td><input type="text" name="nom-nouveau" value="" /></td>
           <td><input type="text" name="sieges-nouveau" size="5" value="" /></td>
           <td></td>
       </tr>
    </table>

    <input type="submit" value="Enregistrer" />
    </form>
~ } ~
~[/content]~
