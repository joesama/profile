@extends('profile::layouts')

@section('action', __('profile::reset.welcome'))

@section('notes', __('profile::reset.note'))

@section('content')
<form class="flex flex-col pt-1 cursor-auto" method="POST" action="{{ $uri }}">
    <input name="identity" value="{{ $identity }}" type="hidden" />
    <div class="flex flex-col pt-4">
        <label for="email" class="text-lg">{{ __('profile::verification.input.key') }}</label>
        <input type="text" name="key" value="{{ old('key') }}" placeholder="{{ __('profile::verification.input.key') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
    </div>  

    <div class="flex flex-col pt-4">
        <label for="password" class="text-lg">{{ __('profile::verification.input.password') }}</label>
        <input type="password" name="password" placeholder="{{ __('profile::verification.input.password') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
    </div>    

    <div class="flex flex-col pt-4">
        <label for="password" class="text-lg">{{ __('profile::verification.input.retype') }}</label>
        <input type="password" name="repassword" placeholder="{{ __('profile::verification.input.retype') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    @csrf
    <input type="submit" value="{{ __('profile::reset.request' ) }}" class="cursor-pointer bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8 rounded-lg">
</form>
@endsection