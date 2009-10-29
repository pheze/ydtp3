~:extend('base')~
~[content]~

~ if (!$is_logged) { ~
    Vous devez être membre pour accéder à cette page.
~ } else { ~
<form id="inscription" action="index.php" method="post">
    <input type="hidden" name="section" value="configuration" />
    <fieldset class="form">
        <legend>Informations d'identification</legend>
        <span><label for="password" class="row">Mot de passe</label><input type="password" id="password" name="password" maxlength="30" /></span>
    </fieldset>
    <fieldset class="form">
        <legend>Informations personnelles</legend>
        <span>
            <label for="prenom" class="row">Prénom</label><input type="text" id="prenom" name="prenom" maxlength="30"
            value="~~$user->prenom~"/>
        </span>
        <span>
            <label for="nom" class="row">Nom</label><input type="text" id="nom" name="nom" maxlength="30"
            value="~~$user->nom~"/>
        </span>
        <span>
            <label for="courriel" class="row">Courriel</label><input type="text" id="courriel" name="courriel"
            maxlength="50" value="~~$user->courriel~"/>
        </span>
        <span>
            <label class="row">Date de naissance</label>
            <select id="jour" name="jour">
                ~ for ($i = 1; $i < 32; $i++) { ~
                    <option ~if ($i == $user->jour) { echo 'selected'; } ~>~~$i~</option>
                ~ } ~
            </select>

            ~ $months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre',
            'Octobre', 'Novembre', 'Décembre'); ~
            
            <select id="mois" name="mois">
                ~ for ($i = 0; $i < count($months); $i++) { ~
                    <option value="~~$i+1~"~if ($i+1 == $user->mois) { echo 'selected'; }~ >~~$months[$i]~</option>
                ~ } ~
            </select>
            <select id="annee" name="annee">
                2010 1900 
                ~ for ($i = 2010; $i >= 1900; $i--) { ~
                    <option ~if ($i == $user->annee) { echo 'selected'; }~ >~~$i~</option>
                ~ } ~
            </select>
        </span>
        <span>
            <label class="row">Sexe</label>
            <input ~if ($user->sexe == 1) { echo 'checked'; }~ type="radio" id="masculin" name="sexe" value="1" /><label for="masculin">Masculin</label>

            <input ~if ($user->sexe == 2) { echo 'checked'; }~ type="radio" id="feminin" name="sexe" value="2"/><label for="feminin">Féminin</label>
        </span>
        <span>
            <label class="row">Theme de la page</label>
            <select id="theme" name="theme">
                <option value="Standard" ~if ($user->theme == "Standard") { echo 'selected'; } ~>Standard</option>
                <option value="Dark" ~if ($user->theme == "Dark") { echo 'selected'; } ~>Foncé</option>
            </select>
        </span>
    </fieldset>
    <p><input type="submit" value="Changer" class="button"/></p>
</form>
~ } ~
~[/content]~
