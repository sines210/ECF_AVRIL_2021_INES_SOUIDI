<x-layout>


<h1>Les Tops</h1>


    <article class="top-ranking">
    
        <ul class="listRank">
        
        @foreach($animes as $anime)

         <li class="anime--header">
          {{$anime->title}}
            {{$anime->description}}
            <img alt="" style="width:15vw; height:20vh; margin: 2% 5%" src="/covers/{{ $anime->cover }}" />
         <strong style="margin-right: 3%;">note des membres </strong>   {{$anime->rating}}/10
          </li>

        @endforeach
        
        </ul>
    
    
    </article>


</x-layout>