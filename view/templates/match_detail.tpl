~:extend('base')~
~[content]~

~ if ($match == null) { ~
    Match inconnu.
 ~} else {~
    <h3>~~$match->description~</h3>
    Date: ~~$match->date~ <br>
    Arena: ~~$match->getArena()->nom~ <br>
    Prix: ~~$match->prix~

    <br><br>todo
    <table>
     <tr>
      <td>1</td><td>2</td>
      <td>1</td><td>2</td>
      <td>1</td><td>2</td>
      <td>1</td><td>2</td>
     </tr>
     <tr>
      <td>3</td><td>4</td>
      <td>1</td><td>2</td>
      <td>1</td><td>2</td>
      <td>1</td><td>2</td>
     </tr>
     <tr>
      <td>5</td><td>6</td>
      <td>1</td><td>2</td>
      <td>1</td><td>2</td>
      <td>1</td><td>2</td>
     </tr>
    </table>
    <br>


    ~if ($is_logged) { ~
      if logged, il faut permettre de reserver. 
    ~}~

 ~}~

~[/content]~
