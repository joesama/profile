<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Profile Verification'))</title>
    <meta name="description" content="{{ __('Profile Verification') }}">

    <!-- Tailwind -->
    <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        .font-family-roboto {
            font-family: 'Roboto Condensed', sans-serif;
        }
    </style>
</head>
<body class="bg-white font-family-roboto h-screen subpixel-antialiased">
    <div id="app" class="w-full flex flex-wrap pt-12 pb-24">
        <div class="mx-auto w-3/5">
            <div class="w-full rounded-lg overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">
                        @yield('action'),
                        <span class="font-light pl-2">{{ $name }}</span>
                    </div>
                    <p class="text-gray-700 text-base whitespace-normal italic ">
                        @yield('notes')
                    </p>
                </div>
            </div>
            <div class="w-full p-0 mt-2 justify-center">
                @if ($errors = $errors->getBag('default')->all())
                    <div class="mt-2 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4 " role="alert">
                    @foreach($errors as $error)
                        <p class="font-semibold leading-relaxed">{{ $error }}</p>
                    @endforeach
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <footer class="fixed inset-x-0 bottom-0 bg-black border-t border-gray-400 shadow-none mt-6">	
        <div class="container max-w-lg mx-auto">
			<p class="leading-snug p-2 text-white text-center">
                @yield('footer', config('app.name'))
			</p>
		</div>
    </footer>
</body>
</html>