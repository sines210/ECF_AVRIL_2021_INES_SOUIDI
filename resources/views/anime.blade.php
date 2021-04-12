<x-layout>
  <x-slot name="title">
    {{ $anime->title }}
  </x-slot>

  <article class="anime">
    <header class="anime--header">
      <div>
        <img alt="" src="/covers/{{ $anime->cover }}" />
      </div>
      <h1>{{ $anime->title }}</h1>
    </header>
    <p>{{ $anime->description }}</p>
    <p>    <h2>Note membres :  {{ $rate->rating }}/10</h2> </p>
    <div>
      <div class="actions">
        <div>
          <a class="cta" href="/anime/{{ $anime->id }}/new_review">Écrire une critique</a>
        </div>
        <form action="/anime/{{ $anime->id }}/add_to_watch_list" method="POST">
        <input type="hidden" name="watchlist_title" value="{{ $anime->title }}"/>
        <input type="hidden" name="watchlist_cover" value="{{ $anime->cover}}"/>
        @csrf
          <button class="cta">Ajouter à ma watchlist</button>
        </form>
      </div>
    </div>
    @foreach ($reviews as $review)

    <form action="getReviews" method="GET">
      <div class="showReviews" style="border:2px dashed black;">

        <ul class="reviews">
           <li><span><strong>{{ $review->username }} :</strong> </span><span>{{ $review->comment }}</span></li>
         </ul>

       </div>  
    </form>
    @endforeach

  </article>
</x-layout>
