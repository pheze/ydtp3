~:extend('base')~
~[content]~
~ if (!$is_logged || !$is_admin) { ~
Vous n'êtes pas administrateur.
~ } else { ~
    <p><a href="index.php?section=admin">Back to admin</a></p>
    Matches:<br>
    <table>

    <form action="index.php" method="post">
    ~ $counter = 0; ~
       <tr>
          <th>date</th>
          <th>description</th>
          <th size="5">prix</th>
          <th>arena</th> 
          <th>effacé</th>
        </tr>
     ~ foreach ($matches as $match) { ~
       <tr>
            <td><input type="text" size="10" name="date~~$counter~" value="~~$match->date~" /></td>
            <td><input type="text" size="10" name="description~~$counter~" value="~~$match->description~" /></td>
            <td><input type="text" size="5" name="prix~~$counter~" value="~~$match->prix~" /></td>
            <td>
               <select name="arena~~$counter~"
                ~ foreach ($arenas as $arena) { ~
                    <option value="~~$arena->id~" 
                    ~if ($arena->id==$match->arena) {~ 
                      selected  
                    ~}~ 
                >~~$arena->nom~</option>
                ~ } ~
                </select>
            </td>
            <td><input type="checkbox" name="delete~~$counter~" /></td>
        </tr>

        ~ $counter++; ~
    ~ } ~

      <tr><td /><td /><td /></tr>
      <tr>
           <input type="hidden" name="section" value="admin_matches" />
           <td><input type="text" size="10" name="date-nouveau" value="" /></td>
           <td><input type="text" size="10" name="description-nouveau" value="" /></td>
           <td><input type="text" size="5" name="prix-nouveau" value="" /></td>
           <td>
               <select name="arena-nouveau">
                ~ foreach ($arenas as $arena) { ~
                    <option value="~~$arena->id~">~~$arena->nom~</option>
                ~ } ~
                </select>
           </td>
           <td></td>
       </tr>
    </table>

    <input type="submit" value="Enregistrer" />
    </form>
~ } ~
~[/content]~
