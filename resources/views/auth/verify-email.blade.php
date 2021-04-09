<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            Merci pour votre inscription <br>
            Nous vous avons envoyé un e-mail avec un lien sur lequel cliquer pour confirmer votre inscription <br>
            Si vous n'avez pas reçu notre mail cliquez pour que l'on vous en renvoie un
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Renvoyer un e-mail de confirmation') }}
                    </x-button>
                </div>
            </form>

       
        </div>
    </x-auth-card>
</x-guest-layout>
