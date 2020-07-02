@extends('profile::layouts')

@section('action', __('profile::' . $type . '.verified'))

@section('notes', __('profile::' . $type . '.success'))

@section('content')
<div class="mt-2 flex justify-center">
    <a href="{{ route('login') }}" class="button bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
        {{ __('profile::profile.button.home') }}
    </a>
</div>
@endsection