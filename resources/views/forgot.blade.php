@extends('profile::layouts')

@section('action', __('profile::forgot.welcome'))

@section('notes', __('profile::forgot.note'))

@section('content')
<form class="flex flex-col pt-1 cursor-auto" method="POST" action="{{ $uri }}">
    <div class="flex flex-col pt-4">
        <label for="email" class="text-lg">{{ __('profile::forgot.email') }}</label>
        <input type="text" name="email" value="{{ old('email') }}" placeholder="{{ __('profile::forgot.email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    @csrf
    <input type="submit" value="{{ __('profile::forgot.request') }}" class="cursor-pointer bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8 rounded-lg">
</form>
@endsection