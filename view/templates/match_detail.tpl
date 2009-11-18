~:extend('base')~
~[scripts]~

<script type="text/javascript">

function ajustCell(i, j, state) {
  document.getElementById(i + '-' + j).className = state;
}

function sendRequest(url, success) {


        var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	{
		if(xmlhttp.readyState==4)
		{
		 	success(xmlhttp.responseText);
		} 
	}

	
	xmlhttp.open("GET", url, true);
	xmlhttp.send(null);

}

 function getUrlState(i, j, match_id, userid) {
  return 'match_detail_ajax.php?id=' + match_id + '&i=' + i + '&j=' + j + '&userid=' + userid; 
 }

function mouseOverCell(i, j, match_id, userid) {
 document.getElementById("position").innerHTML = "Rangée: " + i + " / Siège: " + j;
 
var url = getUrlState(i, j, match_id, userid);

 sendRequest(url, function (state) {
   ajustCell(i,j,state);
 });
}


function unreserve(i, j, match_id, userid) {
 var url = 'index.php?section=match_unreserve_ajax&id=' + match_id + '&i=' + i + '&j=' + j;
 sendRequest(url, function (result) {
  if (result == 'log_err \n') {
   alert('Vous devez vous identifier afin de réserver un match');
  } else if (result != '1') {
   alert('Erreur lors de l\'opération.');
  }

 var url = getUrlState(i, j, match_id, userid);
 sendRequest(url, function (state) {
   ajustCell(i,j,state);
 });

 });
}

function reserve(i, j, match_id, userid) {
 var url = 'index.php?section=match_reserve_ajax&id=' + match_id + '&i=' + i + '&j=' + j;
 sendRequest(url, function (result) {
 
  if (result == 'log_err \n') {
   alert('Vous devez vous identifier afin de réserver un match');
  } else if (result != '1') {
   alert('Erreur lors de la reservation ');
  }

 var url = getUrlState(i, j, match_id, userid);
 sendRequest(url, function (state) {
   ajustCell(i,j,state);
 });

 });
}

function clickOnCell(i, j, match_id, userid) {
 var url = getUrlState(i, j, match_id, userid);

 sendRequest(url, function (state) {
  if (state == 'siege_achete_autre\n') {
   alert('Ce siège a déjà été acheté par un autre utilisateur..');
  } else if (state == 'siege_reserve_autre\n') {
   alert('Ce siège est déjà réservé par un autre utilisateur.');
  } else if (state == 'siege_achete_moi\n') {
   alert('Vous avez déjà acheté ce siege.');
  } else if (state == 'siege_reserve_moi\n') {
   unreserve(i, j, match_id, userid);   
  } else if (state == 'siege_disponible\n') {
   reserve(i, j, match_id, userid);
  } else {
 }
  
 
});
}

</script>

~[/scripts]~
~[content]~

~ if ($match == null) { ~
	Match inconnu.
		~} else {~
			<h3>~~$match->description~</h3>
				Date: ~~$match->date~ <br>
				Arena: ~~$arena->nom~ <br>
				Prix: ~~$match->prix~

				<br>

				<span id="position"></span>

				<table class="match">
				~for($i=0; $i<$arena->profondeur; $i++) {~
					<tr>
						~for($j=0; $j<$arena->largeur; $j++) {~
							<td width="20" height="20" id="~~$i~-~~$j~" 
                                                            onmouseover="mouseOverCell(~~$i~, ~~$j~, ~~$match->id~, ~~$userid~)" 
                                                            onclick="clickOnCell(~~$i~, ~~$j~, ~~$match->id~, ~~$userid~)" 
							    class="~~$classes[$i][$j]~">
								</td>
								~}~ 
								</tr>
								~}~
								</table>

								~if ($is_logged) { ~
										~}~

											~}~

											~[/content]~
