<?php

// insérer le script dans le footer
// l'action appelée avec 'add_action' est la fonction 'oli_plugin_script' (le deuxième argument) et elle aura lieu au moment du chargement du footer grâce à 'wp_footer' (en premier argument).
add_action( 'wp_footer', 'oli_plugin_script' );

// on appelle la page contenant le script avec "include" de php. Au moment de lire le footer, le script sera lu également, comme si il était écrit dans le footer.
function oli_plugin_script(){
  include("oli_script.php");
};
// Créez la page script avant de continuer celle-ci. Placez-la dans le même dossier que celle-ci: 'action/oli_script.php'.
// Vous changez certainement les noms de vos fichiers, n'oubliez pas de modifier les scripts, fonctions et appels wp en conséquence.

/************************************************************************************************************ */
/************************************************************************************************************ */
/*
Petite parenthèse pour tester votre plugin.
Avant d'aller plus loin, notez cette appel à l'action (hors commentaire):

add_action( 'wp_footer', 'oli_plugin' );
function oli_plugin(){
    echo('<p>Le plugin laisse une trace</p>');
};

Si vous avez activé votre plugin, cette fonction devrez afficher le message 'Le plugin laisse une trace' dans votre footer. Vérifiez le bas de page de votre site.
Ca fonctionne? Tout est bien en place, on peut continuer.
Sinon, assurez-vous que vos fichiers soient rangés correctement. Vérifiez leur nom et les correspondances des liens d'appel.
Ensuite, vous pouvez supprimer cette partie.
Fin de la parenthèse de test.
*/
/************************************************************************************************************ */
/************************************************************************************************************ */


// appel de la feuille de style dédiée au plugin, dans la partie <head> avec wp_head (même type d'action que pour wp_footer)
add_action('wp_head', 'oli_plugin_style');

// dans la fonction ci-dessous, appeller l'url de 'bloginfo' donne le lien vers la racine du site, incluant http(s). Fonctionalité Wordpress.
// ?v='.time(), ajouté au bout de l'URL de la feuille de style, permet de charger la toute dernière version du css enregistré et actualise le css mis en cache par le navigateur.
// la requête media peut avoir la valeur 'print', 'screen', 'speech', ou 'all', selon que le css est destiné à l'impression sur papier, l'affichage sur écran, la "lecture" d'écran à "voix haute", ou les 3. Ici, le bouton de navigation ne sert qu'à l'affichage sur écran, on lui attribue donc 'screen'. Par défaut: media vaut 'all' depuis HTML5 (avant, c'était 'screen'). Cette requête est facultative.
function oli_plugin_style(){
  echo('<!-- ----- CSS -  Oli Plugin Style ------ -->'); // insertion d'un commentaire dans la feuille de style. Ce sera plus visuel pour retrouver noter code en affichant la source ou via l'inspecteur du navigateur.
  ?>
  <link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/plugins/oli_plugin/css/oli_plugin_style.php?v='.time()" type="text/css" media="screen">
  <?php
};

            /*
            dans le code source de la partie head, cela donnera, par exemple:

            <!-- ----- CSS -  Oli Plugin Style ------ -->
            <link rel="stylesheet" href="http://localhost/CMS-Restaurant/wp-content/plugins/oli_plugin/css/oli_plugin_style.php?v='.time()" type="text/css" media="screen">

            (si WP est installé à la racine du site, dans www) 
            ou avec un lien qui ressemble à http://localhost/mondossierWP/wp-content/... si vous travaillez en local.

            Note: dans l'inspecteur d'éléments de votre navigateur, cela peut apparaitre dans la partie <body>
            */

//--------------------//

// La fonction suivante résoud un problème concernant la page settings du plugin. Vous la comprendrez plus tard, lorsque vous arriverez au moment de mettre en forme le résultat des changements opérés via la page des paramètres du plugin, dans l'administation de votre Wordpress. Si vous ne faites pas la partie admin du plugin, passez cette fonction.

/* Le changement de couleur est enregistré dans la base de données. Le code de la feuille de style n'est pas modifié. Aucune nouvelle version n'est donc enregistrée. Le navigateur, malgré l'ajout de ?v='.time() ne va donc pas y lire un nouveau code temps et ne va pas recharger la feuille de style (ce qui permettait de télécharger le code couleur depuis la BDD). Il va se contenter d'appliquer le code couleur reconnu au dernier chargement de la feuille de style, il l'a en cache.
Pour contourner la feuille de style en cache, insèrez ici le code couleur depuis la bdd: cette fonction place le style du background du bouton directement dans le <head> de chaque page du site. De cette façon, dès qu'une page est chargée, même avec le css en cache, la nouvelle couleur est appliquée. */
add_action('wp_head', 'oli_plugin_bg_style');
function oli_plugin_bg_style(){
  echo('<!-- ----- CSS -  Oli Plugin Background Style AutoUpdate ------ -->'); 
  $colorResult = get_option('color_buttonUP_OliPlugin', '#292929');
  ?>
  <style type="text/css" media="screen">a#cRetour{ background: <?= $colorResult ?>;}</style>
  <?php
};



/* *********************************************************************************************************** */
/* *********************************************************************************************************** */

// mise en place du bouton cliquable, avec un lien vers l'ancre '#haut'
// dont '#haut' est placé dans le top de la partie <body> du site avec send_headers
add_action( 'send_headers', 'oli_plugin_button' );

// insertion de l'ancre #haut, en mettant un ID 'haut' (un idéal?) sur la DIV
// dans le script, on voit que la classe du bouton nommée ici 'cInvisible' sera changée en 'cVisible', au scroll.
// on retrouvera l'id "cRetour" et les classes "cInvisible" et "cVisible" dans la feuille de style
function oli_plugin_button(){
  echo('<!-- ----- #haut -  Oli Plugin ------ -->');
  ?>
  <div id="haut"><a id="cRetour" class="cInvisible" href="#haut"></a></div>
  <?php
};


/* *********************************************************************************************************** */
/* *********************************************************************************************************** */

/*
Etape suivante: la feuille de style! En .css ou en .php? Créez le dossier css et le fichier oli_plugin_style.php
--------------------------
Unr fois la feuille de style complétée, avec les pages oli_plugin.php, oli_plugin_functions.php, oli_script.php et la page css, le plugin est utilisable.
Vous pouvez vérifier votre site: descendez sur une page, le bouton apparait en bas à droite.
Pour permettre à l'administrateur d'adapter la couleur du bouton à son design, on crée un page de paramètres (settings).
Pour le panneau d'aministration, création d'un nouveau fichier: oli_plugin_pannel.php dans le dossier 'admin'.
*/
