
#PROBLEME DE DEPLOIEMENT 
 Le code a du être un peu modifié pour que le site fonctionne sur Heroku au niveau du passage à clear db, reconstruction de toutes les tables en migration,           probleme de group by sql sur la watchlist. Tous les problèmes ont été résolus ormis un problème sur l'email de vérification car le template de laravel que         j'avais remanié n'est pas pris en compte par heroku, c'est donc l'email avec le texte de laravel qui est envoyé à l'user ; travail en cours


#TACHES TECHNIQUES

   Le code des MVC du site existant, des critiques, de la page des tops et de la watchlist est commenté sur la page de code du controlleur AnimeController 
    
   - VERIFICATTION EMAIL
        - Implémentation du controlleur laravel mustVerifyEmail au modèle user;
        - Création avec les migrations laravel des colonnes email (unique) et email_verified_at (timestamp référencant les dates et heures de la vérification des             emails par l'user);
        - Utilisation du kit LaravelBreeze qui permet dans ce cas d'associer toutes les fonctionnalités de laravel liés à l'envoi d'email de vérification (écoute              d'évènement SendEmailVerificationNotification, vérification de la registration de l'user Illuminate\Auth\Events\Registered, controleur                           d'authentification App\Http\Controllers\Auth templates des mails, connexion à la boite mail de l'envoyeur via le fichier de config mail.php utilisant             les données de connexion présentes dans le fichier d'environnement, utilisation du template de vérification d'email laravel et des templates de layout           d'emails... le tout étant mis en relation via les routes crées dans le routeur
        - Création des routes renvoyées après la registration sign-up  de l'utilisateur 
            1° Route de renvoi vers la page de vérifcation de l'email du site avec lien de renvoi de l'email;
            2° Route de gestion des requetes au clic sur le lien de vérification depuis l'email envoyé à l'user; il est renvoyé à la page d'accueil du site;
            3° Route de revoi de l'email si l'email n'a pas été revoyé en premier lieu route déclenchée au clic sur le bouton de renvoi depuis page vérification ;

        - Les emails sont automatiquement envoyés grace à l'interface mustVerifyEmail implémentée dans le modèle user
        - Customisation de l'email envoyé et de la page de vérification Réécriture du texte
        - Problèmes non résolus par manque de temps : Même si l'utilisateur n'a pas cliqué sur le lien de vérification de l'email, il est quand même loggé au site
          s'il fait un retour en arrière depuis la page de vérification, ce problème vient peut-être du fait qu'au lieu de recréer toute la table des users j'ai                 ajouté les colonnes nécéssaires à l'envoi d'email avec une migration et n'ayant pas codé l'authentification je ne suis pas sure qu'elle soit                         prise en compte dans le la vérification avec le kit breeze ou alors il fallait re-restreidre l'accés au site après registration avec les                          protecting routes de laravel ou alors géré la redirection seulement aux users vérifiés depuis le gestionnaire d'évenement TRAVAIL EN COURS
          
      - PROBLÈME SÉCURITÉ
        Je ne sais pas si c'est le problème de sécurité lié aux sessions mais lorsque un sign-up est fait avec un nom d'user numérique ou trop simple en lettres,         un message de violation des données et compromission du mp apparaît TRAVAIL EN COURS
   
   
# COMPÉTENCES

        - MVC
          Selon les requetes (get ou post dans notre cas) le routeur renvoie au controlleur; au lieu de faire un contrôlleur et un modèle pour chaque route j'ai             créé un controlleur globale (AnimeController) contenant tous les controlleur pour chaque action et un modèle globale (Anime) contenant tous les modèles            une fonction pour chaque requete sql; ainsi depuis chaque route le controlleur AnimeController associé à la fonction que l'on veut utilisé (le mini-              controller) est appelé ; le mini-controlleur détient les fonctions, conditions et variables qu'ils intègre au modèle anime utilise le modèle-anime                get ou post sur la bdd; la vue est renvoyée à la fin de l'éxécution de chaque controlleur;
          Le modèle crée un modèle type des données que l'on va vouloir envoyer ou recevoir en bdd, le controlleur gère toutes les actions de traitement de ces             données et renvoie à la vue désirée.
          
        - PHP/LARAVEL/SQL
           Laravel offre tout un environnement de travail pour coder en php, c'est de la programmation orientée objet ->on créé des objets, des classes                      que l'on réutilise tout au long du développement du projet avec entre autre l'utilsation des namespace qui permettent de définir des classes d'éléments            et de nommer chaque élément associé à cette classe pour les réutiliser de manière simple n'importe où dans le projet avec les  use 
           Laravel offre aussi une architecture structurée basée sur le MVC qui permet de gérer des projet de toute ampleur
           Laravel offre aussi toute une librairie de code prééxistant qui peu être très utile (ici c'était pour la vérification d'emails et l'authentification)              c'est grace à la verif d'email que j'ai pu me familiariser avec une partie de toutes les ramifications présentes dans l'architecture Laravel et les                possibilités sont assez énormes avec aussi la possibilité d'utilisation de kit en nodeJS; il faut du temps pour prendre en main, comprendre la                    documentation et toutes les ramifications;
           Laravel offre aussi la possibilité d'utiliser l'ORM eloquent 
           Pour mes requetes SQL j'ai utilisé le query builder facades plutôt qu'eloquent car je n'arrivais pas trop à comprendre le principe de l'ORM mais j'ai              commencé à utiliser eloquent dans les migrations 
           Laravel offre aussi le systeme de templating php blade qui simplifie beaucoup le code des views, le blade est compilé en PHP et il n'interdit pas de              coder en PHP classique dans la view
           
           En résumé Laravel est un environnement de développement super complet avec une architecture bien construite où il est facile de s'y retrouver un ORM              eloquent pour interagir avec la bdd, une librairie pas trop complexe à réutiliser et beaucoup de possibilités
           
           
           TABLES SQL
            ci-joint MCD/MLD
            4 tables, création des foreign keys, apprentissage des migrations laravel
           
           SÉCURITÉ
           //INJECTION SQL ET FAILLES XSS
           Laravel prémunit des injections sql et des failles XSS avec sa méthode Request->validate de validation des données avant envoi en bdd: l'utilisateur              peut en effet insérer du code JavaScript dans les chaps input (faille xss) ou des injections sql; il faut donc modifier les données avant de les                  envoyer en bdd pour qu'un utilisateur malveillant ne puisse pas y rentrer du code qui sera éxécuté en php plain on utilise les htmlentities ou special            chars et avec laravel c'est la validation avec la méthode Request;
            //CSRF
            Les attaques csrf sont des attaques des users malveillants qui injectent du code dans les requetes des utilisateurs ils rentrent dans les requetes des             utilisateurs et peuvent après redirigés vers les actions de leurs choix; en php plain il vaut donc mieux éviter de faire envoyer des données par                   l'user avec la méthode get (on utilise post et validation de données) Laravel utilise des token chiffré (@csrf dans blade quand on poste des données)             chiffré de manière unique pour chaque session utilisateur : ainsi seul l'utilisateur peut faire des requetes

           

          
    
       
           
