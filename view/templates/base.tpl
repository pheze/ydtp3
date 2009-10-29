<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Canadiens jusqu'au bout du monde</title>
        <link rel="stylesheet" type="text/css" href="/view/css/master.css" />
        <link rel="stylesheet" type="text/css" href="/view/css/~~$theme~" />
    </head>
    <body>
        <div class="wrapper">
            <div class="header">
                <div class="header-logo"><img src="/view/images/logo.jpg" alt="logo"/></div>
                ~ if (!$is_logged) { ~
                <div class="header-login">
                    <div class="header-login-form">
                        <form id="login" action="index.php?section=login" method="post">
                            <p>
                                Usager:<br />
                                <input type="text" name="username"/>
                            </p>
                            <p>
                                Mot de passe:<br />
                                <input type="password" name="password"/>
                            </p>
                            <p>
                                <input type="submit" value="Connexion"/>
                            </p>
                        </form>
                    </div>
                </div>
                ~ } else { ~
                    <div class="header-login">
                        <a href="index.php?section=signout">Signout</a>
                    </div>
                ~ } ~
            </div>
            <div class="left">
				<div class="menu">
	                <ul>
	                    <li><a href="index.php">Accueil</a></li>
	                    ~ if (!$is_logged) { ~ 
                            <li><a href="index.php?section=inscription">Inscription</a></li>
                        ~ } ~
	                    <li><a href="index.php?section=matchs">Matches</a></li>
                        ~ if ($is_logged) { ~
                        <li><a href="index.php?section=panier">Panier</a></li>
                        ~ } ~
	                    ~ if ($is_logged) { ~ 
                            <li><a href="index.php?section=achat">Achats</a></li>
                        ~ } ~
	                    ~ if ($is_logged) { ~ 
                            <li><a href="index.php?section=configuration">Config</a></li>
                        ~ } ~
		                    ~ if ($is_logged && $is_admin) { ~ 
                            <li><a href="index.php?section=admin">Admin</a></li>
                        ~ } ~
		                </ul>
				</div>
            </div>
            <div class="content index-content">
                ~[header]~
                <h2>~~$section_name~</h2> 
                ~[/header]~
                ~[content]~
                ~[/content]~
            </div>
            <div class="right">
                <img src="/view/images/banner.gif" alt="banner" />
            </div>
            <div class="footer">
                <p>Copyright 1999-2009 par <a href="http://www.wix.com/Vechkin94/Poly-Habs">Poly-Habs</a>. Tous droits réservés.</p>
            </div>
        </div>
    </body>
</html>

