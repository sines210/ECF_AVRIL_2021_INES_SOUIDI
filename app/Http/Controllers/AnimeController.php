<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth;




class AnimeController{

    public function showAllAnimes(){

        //le controleur fait appel au modèle Anime avec pour fonction showAllAnimes qui séléctionne tous les champs des animes depuis la BDD
        $anime = new Anime();
        $animes = $anime->allAnimes();

        //il renvoie la vue : 
        return view('welcome', ["animes" => $animes]);
    }

    public function showPageAnimes($id){

        //le controleur fait appel au modèle Anime avec pour paramètre id en utilisant ses fonctions => pageAnimes qui selectionne tous les champs de l'anime à l'id correspondant passé dans l'url; showReview qui selectionne l'username et sa critique depuis les tables user et review liées par une clé étrangère à l'id passé en url; showRate qui sélectionne la note moyenne donnée par les utilisateurs depuis la table review à l'id passé en url

        $animes = new Anime();
        $anime = $animes->pageAnimes($id);
        $reviews = $animes-> showReview($id);
        $rate = $animes -> showRate($id);
        
        //il renvoie la vue : 
        return view('anime', ["anime" => $anime, "reviews" => $reviews, "rate" => $rate]);
    }


  
    public function newReview(Request $request, $id) {
       
        // le contrôleur valide les données passées dans les champs input (champs qui doivent obligatoirement être remplis + ajout du token @csrf pour être validés) et les assigne aux champs correspondants qui vont partir en bdd dans le modèle anime fonction newAnimeReview ainsi que l'id unique de la review; création d'une valeur unique pour chaque review d'utilisateur (champ unique en bdd) ce qui permet d'éviter qu'un utilisateur puisse écrire plusieurs review pour un meme anime (la valeur est composée de l'id de l'utilisateur et de l'id de l'anime le tout encapsulé dans des dollars); le tout est passé dans un try catch qui à pour condition d'erreur que si la review publiée revoie à une erreur de code 1062 (ou champ dupliqué), un message d'erreur sera affiché expliquant à l'utilisateur qu'il ne peut pas écrire plusieurs review pour un meme anime
        //ce controleur à pour paramètre Request qui est une classe orientée objet laravel qui permet ici de valider les données des input et l'id de l'anime passé en url

        try{     
             $validatedComment = $request->validate(["comment" => "required"]);
            $validatedRate = $request->validate(["rating" => "required"]);   
            $aId = auth()->id();
            $auth_id= "$" . $id . "$" . $aId;

            $animes = new Anime();
                $animes->comment = $validatedComment['comment'];
                $animes->rating = $validatedRate['rating'];
                $animes->auth_id = $auth_id;
                $animes->pageAnimes($id);
                  
           
                $animes->newAnimeReview($id);
         
                    //il renvoie la vue : 
                    return redirect('/');}

          catch(QueryException $e) {
                 $error_code = $e->errorInfo[1];
                        if($error_code == 1062){
                            //il renvoie la vue : 
                            return 'Vous avez déjà ajouté déjà écrit une review pour cet anime';
                        }
                    }
    }
 
    public function showTopRank(){

        //fait appel au modèle Anime fonction listTopRank qui sélectionne en bdd les notes moyenne des users(moyenne faite en sql arrondie au premier chiffre après la virgule), les cover, titres et description des animes dans les tables review et animes jointes par une fk, toute cette sélection est groupée par id des animes et ordonée en descendant de la note la plus élevée à la pus basse

        $list = new Anime();
        $animes = $list->listTopRank();

         //il renvoie la vue : 
        return view ('top', ['animes'=>$animes]);
    }

    public function createWatchlist(Request $request, $id){

        //Ici le controlleur prend pour condition que si l'utilisateur ne s'est pas identifié, il ne peut pas créer de watchlist et est renvoyé sur la page de login; sinon lorsqu'il clic sur l'ajout à la watchlist on post un formulaire avec deux input cachés associés aux valeurs du titre et de la cover de l'anime dont l'id est en url, l'id de l'anime et l'id de l'user , ces input sont validés par la request, avec l'id de l'user et un id unique cover_id pour éviter qu'il n'ajoute deux fois le meme anime à sa watchlist; le tout est envoyé en bdd via le modèle anime fonction addToWatch et l'user est redirigé vers la page d'accueil

        if (!Auth::check()) {
        
          //il renvoie la vue : 
        return view('login');}

      else{    
           try{
        $validateTitle = $request->validate(['w_title'=> 'required']);
        $validateCover = $request->validate(['w_cover'=> 'required']);
        $aId = auth()->id();
        $a = $request->input('w_title');
        $c = $request->input('w_cover');
        //création d'un champ unique correspondant à une string avec les 2 champs plus authenticate pour éviter les duplicate
        $cover_id= $a. $c . $aId;

        $animes = new Anime();
        $animes->watchlist_title = $validateTitle['w_title'];
        $animes->watchlist_cover = $validateCover['w_cover'];
        $animes->cover_id = $cover_id;

        $animes->pageAnimes($id);
        $animes->addToWatch($id);
        
        //il renvoie la vue : 
        return redirect('/');
    }
    //ici le try catch nous permet de gérer les erreurs de type duplicate sql (l'user ne peut pas rentrer plus d'une fois le meme anime dans la table watch_list => ici on utilise la classe QueryException et ses méthodes de gestion des erreurs chemin en début de page, et on lui dit que si laravel nous renvoie une erreur de code 1062 (duplicate sql) alors on renvoie un message d'erreur à l'user;

    catch(QueryException $e) {
        $error_code = $e->errorInfo[1];
        if($error_code == 1062){
          
            //il renvoie la vue : 
            return 'Vous avez déjà ajouté cet anime à votre watchlist';
        }
    }
  }
}
   

    public function showWatchList(){
        // récupération des titres et cover des animes via le modèle anime fonction selectWatchList depuis la table watch_list où la fk user_watch_id correspond à l'id de l'user

        $list = new Anime();
        $animes = $list->selectWatchList();
        
        //il renvoie la vue : 
        return view('watchlist', ['animes'=>$animes]);
    }


}