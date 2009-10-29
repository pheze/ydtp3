~:extend('base')~
~[content]~

~ if ($is_logged && !isset($contains_errors)) { ~
    Vous êtes déjà identifié en tant que membre :)
~ } else { ~
    ~ if ($page_type != 'normal' && !$contains_errors) { ~
        Vous êtes maintenant inscris.
    ~ } else { ~
        <p class='inscription_error'>
        ~ if ($contains_errors) { ~
            Il y a des erreurs dans le formulaire : <br>
            <ul>
            ~foreach ($errors as $e) { ~
                <li>~~$e~</li>
            ~ } ~
            </ul>
        </p>
        ~ } ~

<form id="inscription" action="" method="post">
    <fieldset class="form">
        <legend>Informations d'identification</legend>
        <span><label for="username" class="row">Nom d'usager</label><input type="text" id="username" name="username" maxlength="30" /></span>
        <span><label for="password" class="row">Mot de passe</label><input type="password" id="password" name="password" maxlength="30" /></span>
    </fieldset>
    <fieldset class="form">
        <legend>Informations personnelles</legend>
        <span><label for="prenom" class="row">Prénom</label><input type="text" id="prenom" name="prenom" maxlength="30" /></span>
        <span><label for="nom" class="row">Nom</label><input type="text" id="nom" name="nom" maxlength="30" /></span>
        <span><label for="courriel" class="row">Courriel</label><input type="text" id="courriel" name="courriel" maxlength="50" /></span>
        <span>
            <label class="row">Date de naissance</label>
            <select id="jour" name="jour">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                <option>13</option>
                <option>14</option>
                <option>15</option>
                <option>16</option>
                <option>17</option>
                <option>18</option>
                <option>19</option>
                <option>20</option>
                <option>21</option>
                <option>22</option>
                <option>23</option>
                <option>24</option>
                <option>25</option>
                <option>26</option>
                <option>27</option>
                <option>28</option>
                <option>29</option>
                <option>30</option>
                <option>31</option>
            </select>
            <select id="mois" name="mois">
                <option value="1">Janvier</option>
                <option value="2">Février</option>
                <option value="3">Mars</option>
                <option value="4">Avril</option>
                <option value="5">Mai</option>
                <option value="6">Juin</option>
                <option value="7">Juillet</option>
                <option value="8">Août</option>
                <option value="9">Septembre</option>
                <option value="10">Octobre</option>
                <option value="11">Novembre</option>
                <option value="12">Décembre</option>
            </select>
            <select id="annee" name="annee">
                <option>2010</option>
                <option>2009</option>
                <option>2008</option>
                <option>2007</option>
                <option>2006</option>
                <option>2005</option>
                <option>2004</option>
                <option>2003</option>
                <option>2002</option>
                <option>2001</option>
                <option>2000</option>
                <option>1999</option>
                <option>1998</option>
                <option>1997</option>
                <option>1996</option>
                <option>1995</option>
                <option>1994</option>
                <option>1993</option>
                <option>1992</option>
                <option>1991</option>
                <option>1990</option>
                <option>1989</option>
                <option>1988</option>
                <option>1987</option>
                <option>1986</option>
                <option>1985</option>
                <option>1984</option>
                <option>1983</option>
                <option>1982</option>
                <option>1981</option>
                <option>1980</option>
                <option>1979</option>
                <option>1978</option>
                <option>1977</option>
                <option>1976</option>
                <option>1975</option>
                <option>1974</option>
                <option>1973</option>
                <option>1972</option>
                <option>1971</option>
                <option>1970</option>
                <option>1969</option>
                <option>1968</option>
                <option>1967</option>
                <option>1966</option>
                <option>1965</option>
                <option>1964</option>
                <option>1963</option>
                <option>1962</option>
                <option>1961</option>
                <option>1960</option>
                <option>1959</option>
                <option>1958</option>
                <option>1957</option>
                <option>1956</option>
                <option>1955</option>
                <option>1954</option>
                <option>1953</option>
                <option>1952</option>
                <option>1951</option>
                <option>1950</option>
                <option>1949</option>
                <option>1948</option>
                <option>1947</option>
                <option>1946</option>
                <option>1945</option>
                <option>1944</option>
                <option>1943</option>
                <option>1942</option>
                <option>1941</option>
                <option>1940</option>
                <option>1939</option>
                <option>1938</option>
                <option>1937</option>
                <option>1936</option>
                <option>1935</option>
                <option>1934</option>
                <option>1933</option>
                <option>1932</option>
                <option>1931</option>
                <option>1930</option>
                <option>1929</option>
                <option>1928</option>
                <option>1927</option>
                <option>1926</option>
                <option>1925</option>
                <option>1924</option>
                <option>1923</option>
                <option>1922</option>
                <option>1921</option>
                <option>1920</option>
                <option>1919</option>
                <option>1918</option>
                <option>1917</option>
                <option>1916</option>
                <option>1915</option>
                <option>1914</option>
                <option>1913</option>
                <option>1912</option>
                <option>1911</option>
                <option>1910</option>
                <option>1909</option>
                <option>1908</option>
                <option>1907</option>
                <option>1906</option>
                <option>1905</option>
                <option>1904</option>
                <option>1903</option>
                <option>1902</option>
                <option>1901</option>
                <option>1900</option>
            </select>
        </span>
        <span>
            <label class="row">Sexe</label>
            <input type="radio" id="masculin" value = "m" name="sexe" /><label for="masculin">Masculin</label>
            <input type="radio" id="feminin" value="f" name="sexe" /><label for="feminin">Féminin</label>
        </span>
        <span>
            <label class="row">Thème de la page</label>
            <select id="theme" name="theme">
                <option value="Standard">Standard</option>
                <option value="Dark">Foncé</option>
            </select>
        </span>
        <span><label for="accepte" class="row">Termes</label><input type="checkbox" id="accepte" name="accepte" /><label>J'accepte les termes de la license</label></span>
    </fieldset>
    <p><input type="submit" value="J’accepte" class="button"/><input type="reset" value="Réinitialiser" class="button"/></p>
</form>
 ~ } ~
~ } ~
~[/content]~
