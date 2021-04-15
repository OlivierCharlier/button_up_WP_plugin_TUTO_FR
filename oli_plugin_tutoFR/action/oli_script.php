<script>
    // ce script se déclenche à l'action du scroll et change la classe du bouton, à un moment désigné par 'window.pageYOffset'. 
    document.addEventListener('DOMContentLoaded', function() {
       window.onscroll = function(ev) {
       document.getElementById("cRetour").className = (window.pageYOffset > 100) ? "cVisible" : "cInvisible";
       // info : https://developer.mozilla.org/en-US/docs/Web/API/Window/pageYOffset => 100 vaut 100px du top de la fenêtre courante.
       // au passage du centième pixel vers le bas (window.pageYOffset > 100), l'élément devient "cVisible" au lieu de "cInvisible". Il reprend sa classe "cInvisible" quand on repasse le pixel 100 vers le haut.
       };
    });
</script>