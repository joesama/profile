<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Profile Verification') }}</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }
    </style>
</head>
<body class="bg-white font-family-karla h-screen subpixel-antialiased">
    <div id="app" class="w-full flex flex-wrap pt-12 pb-24">
        <div class="mx-auto">
            <div class="max-w-lg rounded-lg overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">
                        {{ __('profile::' . $type . '.welcome') }}, 
                        <span class="font-light pl-2">{{ $name }}</span>
                    </div>
                    <p class="text-gray-700 text-base whitespace-normal italic ">
                        {{ __('profile::' . $type . '.note') }}
                    </p>
                </div>
                @if ($errors = $errors->getBag('default')->all())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-2 " role="alert">
                @foreach($errors as $error)
                    <p class="font-semibold leading-relaxed">{{ $error }}</p>
                @endforeach
                </div>
                @endif
            </div>
            <form class="flex flex-col pt-2 cursor-auto" method="POST" action="{{ route('profile.'. $type) }}">
                <input name="identity" value="{{ $identity }}" type="hidden" />
                <div class="flex flex-col pt-4">
                    <label for="email" class="text-lg">{{ __('profile::' . $type . '.input.key') }}</label>
                    <input type="text" name="key" placeholder="{{ __('profile::' . $type . '.input.key') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="flex flex-col pt-4">
                    <label for="username" class="text-lg">{{ __('profile::' . $type . '.input.username') }}</label>
                    <input type="text" name="username" placeholder="{{ __('profile::' . $type . '.input.username') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                </div>    

                <div class="flex flex-col pt-4">
                    <label for="password" class="text-lg">{{ __('profile::' . $type . '.input.password') }}</label>
                    <input type="password" name="password" placeholder="{{ __('profile::' . $type . '.input.password') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                </div>    

                <div class="flex flex-col pt-4">
                    <label for="password" class="text-lg">{{ __('profile::' . $type . '.input.retype') }}</label>
                    <input type="password" name="repassword" placeholder="{{ __('profile::' . $type . '.input.retype') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                @csrf
                <input type="submit" value="{{ __('profile::' . $type . '.button.action' ) }}" class="cursor-pointer bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8 rounded-lg">
            </form>
        </div>
    </div>
    <footer class="fixed inset-x-0 bottom-0 bg-black border-t border-gray-400 shadow-none mt-6">	
        <div class="container max-w-lg mx-auto">
			<p class="leading-snug p-2 text-white text-center">
				{{ config('app.name') }}
			</p>
		</div>
    </footer>
</body>
</html>