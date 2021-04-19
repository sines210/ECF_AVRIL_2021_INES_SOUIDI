<x-layout>


<h1>Ma watchlist</h1>


    <article class="watch_list">
    
        <div class="w_list">
        
        @foreach($animes as $anime)
        <span class="anime--header">
            <strong style="margin: 3%;"> {{$anime->w_title}}</strong>
               <img alt="" style="width:15vw; height:20vh; margin: 2% 5%" src="/covers/{{$anime->w_cover}}" />
        </span>
        <span class="anime--header">
             <form action="deleteFromWatchList" method="POST">
                <input type="hidden" name="watchListId" value="{{$anime->cov_id}}"/>
                <button type="submit" class="cta" value="supprimer">Supprimer</button>
                @csrf
             </form>
          </span>

        @endforeach
        
        </div>
    
    </article>


</x-layout>