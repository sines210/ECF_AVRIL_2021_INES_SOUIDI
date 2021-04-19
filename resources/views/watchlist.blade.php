<x-layout>


<h1>Ma watchlist</h1>


    <article class="watch_list">
    
        <ul class="w_list">
        
        @foreach($animes as $anime)

        <li class="anime--header">
            <strong style="margin: 3%;"> {{$anime->w_title}}</strong>
               <img alt="" style="width:15vw; height:20vh; margin: 2% 5%" src="/covers/{{$anime->w_cover}}" />
          </li>
          <li class="deleteWatchAnime">
             <form action="deleteFromWatchList" method="POST">
                <input type="hidden" name="w_list_anime_id" value="{{$anime->cov_id}}"/>
                <button type="submit" value="supprimer"></button>
                @csrf
             </form>
          </li>

        @endforeach
        
        </ul>
    
    </article>


</x-layout>