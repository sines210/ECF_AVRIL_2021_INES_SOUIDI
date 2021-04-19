<x-layout>


<h1>Ma watchlist</h1>


    <article class="watch_list">
    
        <ul class="w_list">
        
        @foreach($animes as $anime)
        <div class="anime--header">
            <span>
                <li>
                  <strong style="margin: 3%;"> {{$anime->w_title}}</strong>
                   <img alt="" style="width:15vw; height:20vh; margin: 2% 5%" src="/covers/{{$anime->w_cover}}" />
                </li>
            </span>
            <span style="margin-left: 8%;">
                 <li class="deleteWatchAnime" style="list-style-type: none;">
                     <form action="deleteFromWatchList" method="POST">
                          <input type="hidden" name="watchListId" value="{{$anime->cov_id}}"/>
                         <button type="submit" class="cta" value="supprimer">Supprimer</button>
                         @csrf
                    </form>
                 </li>
             </span>
          </div>

        @endforeach
        
        </ul>
    
    </article>


</x-layout>