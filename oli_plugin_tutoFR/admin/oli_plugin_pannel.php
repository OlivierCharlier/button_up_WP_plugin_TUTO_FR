<?php

// Ici, création de la page d'administration dans le tableau de bord de Wordpress, accessible aux utilisateurs ayant le rôle d'administrateur.


// Hook sur l'action 'admin_menu' et lance la fonction 'oli_admin' décrite plus bas. PHP évalue le script entier avant de l’exécuter, on peut donc avoir le hook avant de définir la fonction qu'il appelle. Hook sur WP = Appel d'une fonction (en très simplifié).
add_action('admin_menu', 'oli_admin');

function oli_admin(){
    add_menu_page(// Info codex : https://codex.wordpress.org/Adding_Administration_Menus
                    //'themes.php', // add_submenu_page Vous permet d'insérer votre menu en sous-menu d'un menu existant (par exemple: Apparence > Button UP! où 'themes.php' cible 'Apparence'. Voir plus bas, la liste des noms de  menu à "cibler")
                    'Button Up by Oli', // <title> de la page (apparait, entre autres, dans l'onglet du navigateur). Note: vous pouvez voir l'utilisation de __( 'My Page', 'textdomain' ), sur certaines constructions de plugin.-textdomain- n'est plus requis depuis WP4.6. Il servait à l'internationalisation et devenu obsolète.
                    'Button UP', // titre/nom tel qu'il apparait dans le menu
                    'activate_plugins', // permission/rôle utilisateur nécessaire pour afficher ce menu (voir plus bas, comment définir un rôle)
                    'oli_plugin_pannel', // id unique/slug de votre choix. Limitez les (mal)chances qu'un autre plugin porte le même id que le vôtre.
                    'render_pannel',  // fonction à appeler pour générer le code html de cette page. Elle se trouve plus bas.
                    //'dashicons-arrow-up-alt' //'', // icône dans le menu: décommentez pour avoir une flèche vers le haut à la place de la roue dentée de base, en icone à côté du nom dans le menu. Comme cette ligne est facultative, ne rien noter affiche la roue dentée. Si vous devez utiliser la ligne qui suit, comme la position des lignes a une importance, notifiez alors l'absence de paramètre pour l'icone avec une paire de guillemets simples et une virgule ( '', )
                    //61 //position dans le menu. 61 est juste après Appearance, en 60 (voir plus bas). Note: s'il existe un autre menu 61 présent, il sera écrasé. Ne rien mettre envoi votre menu en bas de la liste. Décommentez 61 pour déplacer votre menu, ou choisissez un nombre selon la liste ci-dessous.
                );
    // Info codex : https://developer.wordpress.org/reference/functions/add_menu_page/
    
};

    // pour définir le rôle d'utilisateur, aller sur la page https://wordpress.org/support/article/roles-and-capabilities/#administrator, choisir une capacité que n'a pas une rôle "inférieur" et l'appliquer ici. L'accès à "activate_plugins" n'est autorisé qu'à partir de "administrateur". On a donc défini notre plugin comme "uniquement accessible pour les administrateurs du site" (et rôles supérieurs si il y en a) en mettant "activate_plugins".

    // codes des icônes disponibles par défault dans WP : https://developer.wordpress.org/resource/dashicons/

    
    /*
    Structure du menu par défaut.
    Vérifiez que votre thème ne le modifie pas. Des plugins existent également pour modifier cet ordre.
    2 – Dashboard
    4 – Separator
    5 – Posts
    10 – Media
    15 – Links
    20 – Pages
    25 – Comments
    59 – Separator
    60 – Appearance
    65 – Plugins
    70 – Users
    75 – Tools
    80 – Settings
    99 – Separator
    */


    // Menu ou Sous-menu? https://developer.wordpress.org/plugins/administration-menus/sub-menus/
       
    /* liste des slugs des menu pour y insérer votre sous-menu:

        add_dashboard_page() – index.php
        add_posts_page() – edit.php
        add_media_page() – upload.php
        add_pages_page() – edit.php?post_type=page
        add_comments_page() – edit-comments.php
        add_theme_page() – themes.php
        add_plugins_page() – plugins.php
        add_users_page() – users.php
        add_management_page() – tools.php
        add_options_page() – options-general.php
        add_options_page() – settings.php
        add_links_page() – link-manager.php – requires a plugin since WP 3.5+
        Custom Post Type – edit.php?post_type=wporg_post_type
        Network Admin – settings.php
    */


    // Retour au code du pannel: fonction qui appelle le html du panneau d'admin du plugin.

    function render_pannel(){
        if(isset($_POST['color_update'])){ // si le formulaire color_update est bien défini, c'est qu'il a été soumis
            //var_dump($_POST); //debug pour afficher sur la page le résultat du formulaire (un test avant d'écrire la vraie fonction)
            if(!empty($_POST['Color'])){
                update_option('color_buttonUP_OliPlugin', $_POST['Color']); //update_option ajoute ou update la table wp_option dans la bdd (wp_ ou autre préfixe si vous l'avez changé) avec la donnée nommée 'color_buttonUP_OliPlugin' qui prend la valeur extraite de Color, selon le bouton radio coché.
            }
        }
// NOTE: quand vous testerez votre page de paramètres. Allez jeter un oeil à votre base de données. Ouvrez la table wp_option et recherchez color_buttonUP_OliPlugin (comme c'est une des dernières données enregistrées sur la base, classez le tout par ID décroissant, vous devriez voir la donnée dans le haut de la liste), vous verrez que sa valeur est celle décidée dans le panneau d'administration. C'est cette valeur que nous allons rechercher pour le style background du bouton (voir la fonction oli_plugin_bg_style dans oli_plugin_functions.php).


/*installation d'un color picker*/
// Plutôt que de laisser à l'administrateur le soin d'écrire lui-même le code couleur en HEX, dans un input texte qu'il faut sécuriser et limiter en caractères, conditionner, etc pour ne pas qu'il se trompe ou lance un code de hack, le color picker limite les valeurs enregistrables aux strictes code HEX, sans faute. Et les novices en couleurs HEX vous disent déjà merci.

// 1. appel en file d'attente du style et du script de la pipette de couleurs et sa palette (color-picker), inclus dans WP.
wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script('wp-color-picker' );
// 2. Préparez le input en ajoutant la 'class', un nom et une valeur par défault (ce code sera placé plus bas)
    // Le précédent code, non sécurisé, basique, limitait seulement le nombre de caractères possible à 7: <input type="text" name="color-code" value="#292929" size="7" maxlength="7"> . Il devient <input type="text" class="colorpicker" name="color-code" value="" data-default-color="#292929" />
    // Mettez le nom de classe que vous souhaitez et pensez à adapter le reste du code.
    // Modifier data-default-color="#292929" si vous voulez une autre couleur par défaut.
// 3. ajouter le script d'appel à jQuery (qui cible la classe créée au point 2)
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.colorpicker').wpColorPicker();
});
</script>
<!-- That's it! Le color picker est prêt. -->



    <div class="wrap theme-options-page"> 
     <!-- wrap permet d'homogénéiser le desing du pannel admin selon les normes WP. A la prochaine mise à jour de WP, il est possible que cela fasse légèrement varier le style de votre page d'administration -->

        <h1><span class="dashicons dashicons-admin-tools"></span> Plugin Button UP by Oli</h1>
        <!-- Une classe dasn un span suffit à insérer un icône de base. Rappel des icônes disponibles par défault dans WP : https://developer.wordpress.org/resource/dashicons/ -->
       
        <h2>Costumize your Button UP!</h2>

        <form action="" method="post" name="colorize"> 
            <!-- la fonction créée plus haut, render_pannel, réagit à la méthode "post" de ce formulaire, avec $POST et cible le nom du bouton submit: color_update. Puis va recherche l'info de 'Color' -->
            <p>Choice the new color of your Button UP:</p>
            <div class="">
                <input type="radio" id="Grey" name="Color" value="#292929"><span style="color:#292929"> Grey - default</span><br>
                <input type="radio" id="Green" name="Color" value="#008000"><span style="color:#008000"> Green</span><br>
                <input type="radio" id="Red" name="Color" value="#FF0000"><span style="color:#FF0000"> Red</span><br>
                <input type="radio" id="Navy" name="Color" value="#000080"><span style="color:#000080"> Navy</span><br>
                <input type="radio" id="Yellow" name="Color" value="#FFFF00"><span style="color:#FFFF00; background:#000000"> Yellow</span><br>
                <!-- Ancien code, avant le colorpicker: <input type="radio" id="$colorValue" name="Color" value="">Your personal color: <input type="text" name="color-code" value="#292929" size="7" maxlength="7"> Please, use HEX color code. To find the code for your favorite color, I suggest you to visit <a href="https://htmlcolorcodes.com/" target="_blank">htmlcolorcodes.com</a>. -->
                <!-- Placer le color picker ici:  -->
                <input type="radio" id="$colorValue" name="Color" value="">Your personal color: <input type="text" class="colorpicker" name="color-code" value="" data-default-color="#292929" />
                    
            </div>
            <p class="submit">
                <!-- Le petit bouton qui balance la sauce -->
                <input type="submit" name="color_update" value="Color it!">
            </p>
        </form>

        <p>The color is currently set to <strong>
        <?php
        // Note: Le code suivant est sans doute à améliorer. Une boucle? Une recherche des éléments déjà codés ci-dessus? #challenge?
        // si l'utilisateur a rempli ET coché le champs texte, le texte est mis dans la DB
        if(!empty($_POST['color-code']) && empty($_POST['Color'])){
            update_option('color_buttonUP_OliPlugin', $_POST['color-code']);
        };
        
        $colorResult = get_option('color_buttonUP_OliPlugin'); // get_option est une fonction WP qui va rechercher la valeur de 'color_buttonUP_OliPlugin' dans la DB

        $colorChoice = "Grey - default";
        if($colorResult === "#292929"){
            $colorChoice =  "Grey - default";
        }elseif($colorResult === "#27b30b"){
            $colorChoice =  "Green";
        }elseif($colorResult === "#FF0000"){
            $colorChoice =  "Red";
        }elseif($colorResult === "#000080"){
            $colorChoice =  "Navy";
        }elseif($colorResult === "#FFFF00"){
            $colorChoice =  "Yellow";
        }else{
            $colorChoice =  "your personal color";
        }
        echo $colorChoice;
        ?></strong> with the code <strong><?= $colorResult ?></strong>.</p>
        <p>Look at this! Here is the look of your funny colorful "Button up!":
        <div id="button_up_demo"></div>
        <p>Your website is updated: <a href="<?php bloginfo('url'); ?>" target="_blank">check it now!</a></p>

        <!-- En mettant le style du bouton demo ici, collé à l'id de la DIV ci-dessus, il n'y a pas de problème de mise en cache du css. Le résultat est affiché immédiatement car la page se recherche quand on clique sur le bouton 'submit' qui balance la sauce. -->
        <style type="text/css">
            #button_up_demo{    
                display: flex;
                align-items: center;
                justify-content: center;  
                border-radius: 15%;
                font-size:25px;
                color:#fff;
                background: <?= $colorResult ?>;
                /* Remarquez l'insertion de la donnée en php dans le background, ce qui n'est pas possible dans une feuille de style .css. Elle vient directement de la BDD.*/
                box-shadow: 1px 1px 4px 1px rgba(255, 255, 255, 0.2);
                /* ci-dessous, ces codes mis en commùentaires, nécessaires au positionnement du bouton sur le site, ne sont pas utiles pour la démo. Vous pouvez les effacer. */
                /* position:fixed; */
                /* right:20px; */
                /* opacity:1; */
                /* z-index:99999; */
                /* transition:all ease-in 0.2s; */
                text-decoration: none;
                height: 50px;
                width: 50px;
                /* bottom: 20px; */
            }
            #button_up_demo:before{
                content: "\25b2";
            } 
        </style>   

    </div>
<?php

};