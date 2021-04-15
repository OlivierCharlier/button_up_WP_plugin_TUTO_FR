
<?php

// les 3 lignes suivantes ont été trouvées sur un tuto, sans elles, impossible à WP de reconnaître le css et de le lier à la base données
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);

// les 2 lignes suivantes permettent à une page .php d'être la feuille de style et de renvoyer au navigateur le code CSS.
header("Content-type: text/css; charset=UTF-8"); // = le serveur doit renoyer un code css
header('Cache-Control: max-age=31536000, must-revalidate'); // mise en cache 
?>


<?php 
/*
Pourquoi utiliser un fichier .php pour la feuille de style?
Mon objectif étati de modifier le style background via un appel de la base de données. Le CSS ne permet pas cela. Une fonction PHP le permet:
  */

// $colorResult = get_option('color_buttonUP_OliPlugin', '#292929');
// get_option reprend la valeur color_buttonUP_OliPlugin dans la DB, et si c'est vide ou que le ligne est inexistante, prend la valeur #292929


/* NOTE: la fonction est efficace. Cependant, la changement du code couleur dans la base de données ne modifie pas le code de cette page-ci. L'appel reste le même. Le timer de la page ne change donc pas.
Rappelez-vous l'ajout à l'URL d'appel de la feuille de style, pour recharger le css si un changment de timer a lieu ici. Il est inefficace pour cette configuration. Devenu obsolète, vous pouvez retourner l'enlever si vous le souhaitez.
Si vous avez suivi les informations incluant la création de la partie settings du plugin, vous comprenez maintenant pourquoi le style du background est placé directement sur chaque page, grâce à une fonction dans oli_plugin_functions.php.
*/
?> 


a#cRetour{
/* construction du bouton tel qu'il doit apparaitre quand il est actif */
      display: flex;
      align-items: center;
      justify-content: center;  
      border-radius: 15%;
      font-size:25px;
      color:#fff;
      <!-- background: <?= $colorResult ?>; -->
      <!-- le style backround est inclus dans chaque page. De cette façon, le css lu en cache appelle aussi la couleur depuis la DB. La partie backround n'a plus sa place ici -->
      box-shadow: 1px 1px 4px 1px rgba(255, 255, 255, 0.2);
      position:fixed;
      right:20px;
      opacity:1;
      z-index:99999;
      transition:all ease-in 0.2s;
      text-decoration: none;
      height: 50px;
      width: 50px;
    }
    a#cRetour:before{ 
      content: "\25b2"; 
    } 
    /* \25b2 est le code Unicode pour le triangle  */

    a#cRetour:hover{
      background:rgba(0, 0, 0, 1);
      transition:all ease-in 0.2s;
    }
    a#cRetour.cInvisible{
      bottom:-35px;
      /* pour qu'il apparaisse depuis sous le bas de la page  */
      opacity:0; 
      /* et donc invisible */
      transition:all ease-in 0.5s;
      /* apparition douce */
    }
    
    a#cRetour.cVisible {
      bottom: 20px;
      /* pour qu'il se place à 20px au-dessus du bas de la page */
      opacity:1;
      /* et donc visible */
    }
    
    html {
      scroll-behavior: smooth;
    /* permet un déplacement souple dans la page (pour les liens internes, #ancres) */
    }

<!-- Feuille de style en .css ou en .php ?
Mon idée de base était d'inclure un appel vers la base de donnée. Cet appel étant maintenant exécuté sur une autre page, mettre la feuille de style en .php ne présente plus d'intérêt en l'état. Vous pouvez donc vous contenter de oli_plugin_style.css  -->
