<?php
// ETAPE 1: ouvrir une balise php (il n'est pas nécessaire de la fermer: il n'y aura que du php sur cette page) et NE RIEN ECRIRE AVANT CETTE BALISE !

// ETAPE 2: préparer les textes du dashboard, EN COMMENTAIRE. 
// Cette partie est obligatoire: c'est l'affichage du plugin dans le tableau de bord, sur la page des "extensions installées" (Menu: Plugins > Installed Plugins)

/*
Plugin Name: Tuto Plugin Button UP!
Plugin URI: https://www.monnomdedomaine.be/plugin
Description: Un bref paragraphe <strong>devrait</strong> suffir. Il est possible d'y insérer un <a href="https://www.monnomdedomaine.be/plugin" target="_blank">lien</a> et un peu de <em>mise en forme</em>.
Author: Sarah <em>Connor</em>
Version: 1.0.2
Author URI: https://www.monnomdedomaine.be
*/


// ! pas d'espace avant les 2 points ! Et noter URI et pas URL.
// Seul le commentaire "Plugin Name" est obligatoire. Les autres, facultatifs pour WP, sont très appréciés par l'utilisateur.
// Liste de tous les éléments facultatifs dans ces commentaires: https://developer.wordpress.org/plugins/plugin-basics/header-requirements/
// Pour que le plugin soit reconnu par WP, il doit se trouver dans le dossier /wp-content/plugins/, soit en un seul fichier php (nom-du-plugin.php, par exemple) ou dans un dossier /nom-du-plugin/ qui contiendra tous les fichiers du plugin (wp-content/plugins/nom-du-plugin/nom-du-plugin.php).

// Vérifier la présence du plugin dans le tableau de bord (Menu > Plugins> Installed Plugins) et l'activer.


// ETAPE 3: insérer ici le code qui ajoute les fonctions du plugin au site WP

// le code des fonctions d'un plugin pourrait être directement placé dans le fichier function.php du thème. En plus de rendre le fichier function.php lourd et illisible, le code ajouté sera effacé à la première mise à jour du thème. On va donc éviter et créer un plugin bien à part.


// Appeler oli_plugin_functions.php en utlisant "require_once" empêche le plugin de se lancer si la page oli_plugin_functions.php n'est pas trouvée.
require_once plugin_dir_path(__FILE__) . 'action/oli_plugin_functions.php';


/*
NOTE:   Using PHP, the include and require statements are identical, except upon failure:
        - require will produce a fatal error (E_COMPILE_ERROR) and stop the script
        - include will only produce a warning (E_WARNING) and the script will continue
*/

/* ********************************************************************************** */

/* SETTINGS */

// on appelle ensuite la page d'administration, si on en a créé une (pour ce plugin-ci, on peut très bien s'arrêter à la base, sans page settings du plugin). Si vous ne voulez pas faire l'administration maintenant, vous pouvez construire le reste du plugin avant de faire cette étape: ouvrez alors oli_plugin_functions.php du dossier 'action'.
require_once plugin_dir_path(__FILE__) . 'admin/oli_plugin_pannel.php';

// le code du lien ci-dessous n'est utile que si le plugin à une page d'administration
function oli_settings_action_links( $links, $file ) {
        
    // ajoute un lien 'Customize it!' (généralement, le lien est nommé "Settings". Il apparait sous le nom du plugin, sur la page des extensions installées) vers la page de config de ce plugin 'admin.php?page=oli_plugin_pannel' (ajouter ce lien ne se trouve pas dans les possibilités du commentaire que nous avons mis en début de page)
    array_unshift( $links, '<a href="' . admin_url( 'admin.php?page=oli_plugin_pannel' ) . '">' . __( 'Customize it!' ) . '</a>' );

    return $links;
}
add_filter( 'plugin_action_links_'.plugin_basename( __FILE__ ), 'oli_settings_action_links', 10, 2 );

    // j'ai trouvé le code de cette fonction sur https://www.geekpress.fr/ajouter-reglages-plugins/
