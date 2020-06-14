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
                        {{ __('profile::' . $type . '.verified') }}, 
                        <span class="font-light pl-2">{{ $name }}</span>
                    </div>
                    <p class="text-gray-700 text-base whitespace-normal italic ">
                        {{ __('profile::' . $type . '.success') }}
                    </p>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ route('login') }}" class="button bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    {{ __('profile::' . $type . '.button.home') }}
                </a>
            </div>
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