# Sortir-com
Projet ENI sortir.com (Symfony)

Procédure de déploiement en Test :
<br>Vérifier dans le fichier .env les informations de la base de données.
<br>Par défaut :
<br>
<ul>
    <li>base de donnée : Mysql</li>
    <li>utilisateur : root</li>
    <li>mot de passe : néant</li>
    <li>adresse : 127.0.0.1</li>
    <li>port : 3306</li>
    <li>nom : sorties</li>
</ul>
<br> Pensez à vérifier tous ces champs et le cas échéant mettre à jour.
<br> Commande à lancer dans un terminal
<br>
<ul>
    <li>php bin/console doctrine:schema:update --force</li>
    <li>php bin/console doctrine:fixtures:load</li>
</ul>
<br> Mettre le serveur en route.
<br><br>
Il y a trois utilisateur par défaut :
<br>
<ul>
    <li>id = Toto / mdp = password / (utilisateur)</li>
    <li>id = JeanN / mdp = password / (organisateur des 4 sorties)</li>
    <li>id = John / mdp = password / (administrateur) </li>
</ul>

<br>En cas de soucisn vous pouvez me contacter à l'adresse: <a href="mailto:jonathan.hamel87@gmail.com">jonathan.hamel87@gmail.com</a>
