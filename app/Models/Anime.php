<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;


class Anime{   

public $comment;
public $rating;
public $username;
public $review;
public $watchlist_title;
public $watchlist_cover;
public $auth_id;
public $cover_id;
    public function allAnimes(){
        return DB::select("SELECT * FROM animes");
    }

    public function pageAnimes($id){
        return DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
    }

    public function newAnimeReview ($id){
       DB::insert("INSERT INTO review (comment, rating, review_id, user_id, anime_id) VALUES (:comment, :rating, :review_id, :user_id, :anime_id)", ["comment" => $this->comment, "rating" => $this->rating, "user_id" => auth()->id(), "anime_id" => $id, "review_id" => $this->auth_id]); 
    }

    public function showReview ($id){
        return DB::select("SELECT  comment, users.username FROM review JOIN users ON review.user_id = users.id AND review.anime_id = ?", [$id]);
    }

    public function listTopRank (){
        return DB::select("SELECT ROUND(AVG(rating), 1) AS rating,  animes.id, animes.title, animes.description, animes.cover FROM review LEFT JOIN animes ON review.anime_id=animes.id  GROUP BY animes.id, animes.title, animes.description, animes.cover ORDER BY ROUND(AVG(rating), 1) DESC");
    }

    public function showRate($id){
       return DB::select("SELECT ROUND(AVG(rating), 1) AS rating FROM review WHERE anime_id = ?", [$id]);
    }