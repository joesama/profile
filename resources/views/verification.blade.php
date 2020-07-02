@extends('profile::layouts')

@section('action', __('profile::' . $type . '.welcome'))

@section('notes', __('profile::' . $type . '.note'))

@section('content')

<form class="flex flex-col pt-1 cursor-auto" method="POST" action="{{ route('profile.'. $type) }}">
    <input name="identity" value="{{ $identity }}" type="hidden" />
    <div class="flex flex-col pt-4">
        <label for="email" class="text-lg">{{ __('profile::' . $type . '.input.key') }}</label>
        <input type="text" name="key" value="{{ old('key') }}" placeholder="{{ __('profile::' . $type . '.input.key') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="flex flex-col pt-4">
        <label for="username" class="text-lg">{{ __('profile::' . $type . '.input.username') }}</label>
        <input type="text" name="username" value="{{ old('username') }}"  placeholder="{{ __('profile::' . $type . '.input.username') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
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

@endsection
