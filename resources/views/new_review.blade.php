<x-layout>
  <x-slot name="title">
    Nouvelle critique de [$anime->title ]
  </x-slot>

  <h1>Nouvelle Critique de [$anime->title ]</h1>

<form action="create_review" method="post">

<label for="rank">Donnez une note de 1 à 10 : </label>
<input type="number" min="1" max="10" name='rating'>
<label for="write_review">Ecrivez votre critique : </label>
<textarea name="comment" id="write_review" cols="30" rows="10"></textarea>
@csrf                  

<input type="submit" value="envoyer">
</form>



</x-layout>
