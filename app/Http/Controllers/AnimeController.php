<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth;




class AnimeController{

    public function showAllAnimes(){

        //le controleur fait appel au modèle :
        $anime = new Anime();
        $animes = $anime->allAnimes();

        //il renvoie la vue
        return view('welcome', ["animes" => $animes]);
    }

    public function showPageAnimes($id){

        //le controleur fait appel au modèle :
        $animes = new Anime();
        $anime = $animes->pageAnimes($id);
        $reviews = $animes-> showReview($id);
        $rate = $animes -> showRate($id);
        
        //il renvoie la vue
        return view('anime', ["anime" => $anime, "reviews" => $reviews, "rate" => $rate]);
    }


  
    public function newReview(Request $request, $id) {
       
        try{     
             $validatedComment = $request->validate(["comment" => "required"]);
            $validatedRate = $request->validate(["rating" => "required"]);   
            $aId = auth()->id();
            //encodage avec $ pour une valeur unique
            $auth_id= "$" . $id . "$" . $aId;

            $animes = new Anime();
                $animes->comment = $validatedComment['comment'];
                $animes->rating = $validatedRate['rating'];
                $animes->auth_id = $auth_id;
                $animes->pageAnimes($id);
                  
           
                $animes->newAnimeReview($id);
         
                    return redirect('/');}
          catch(QueryException $e) {
                 $error_code = $e->errorInfo[1];
                        if($error_code == 1062){
                            return 'Vous avez déjà ajouté cet anime à votre watchlist';
                        }
                    }
    }
 
    public function showTopRank(){
        $list = new Anime();
        $animes = $list->listTopRank();
        // $listTop = $animes->listTopRank();
            return view ('top', ['animes'=>$animes]);
    }

    public function createWatchlist(Request $request, $id){

        if (!Auth::check()) {
        return view('login');}

      else{    
           try{
        $validateTitle = $request->validate(['watchlist_title'=> 'required']);
        $validateCover = $request->validate(['watchlist_cover'=> 'required']);
        $aId = auth()->id();
        $a = $request->input('watchlist_title');
        $c = $request->input('watchlist_cover');
        //création d'un champ unique correspondant à une string avec les 2 champs plus authenticate pour éviter les duplicate
        $auth_id= $a. $c . $aId;

        $animes = new Anime();
        $animes->watchlist_title = $validateTitle['watchlist_title'];
        $animes->watchlist_cover = $validateCover['watchlist_cover'];
         $animes->auth_id = $auth_id;

        $animes->pageAnimes($id);
        $animes->addToWatch($id);
        return redirect('/');
    }
    //ici le try catch nous permet de gérer les erreurs de type duplicate sql (l'user ne peut pas rentrer plus d'une fois le meme anime dans la table watch_list => ici on utilise la classe QueryException et ses méthodes de gestion des erreurs chemin en début de page, et on lui dit que si laravel nous renvoie une erreur de code 1062 (duplicate sql) alors on renvoie un message d'erreur à l'user;

    catch(QueryException $e) {
        $error_code = $e->errorInfo[1];
        if($error_code == 1062){
            return 'Vous avez déjà ajouté cet anime à votre watchlist';
        }
    }
  }
}
   

    public function showWatchList(){
        $list = new Anime();
        $animes = $list->selectWatchList();
        return view('watchlist', ['animes'=>$animes]);
    }


}