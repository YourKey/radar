@extends('layouts.app')
@section('content')
	<div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
		<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h1 class="card-title">Register</h1>
			<!-- Validation Errors -->
			@if ($errors->any())
				<div class="mb-4">
					<div class="font-medium text-red-600">
						{{ __('Whoops! Something went wrong.') }}
					</div>

					<ul class="mt-3 list-disc list-inside text-sm text-red-600">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form method="POST" action="{{ route('register') }}">
			@csrf

			<!-- Name -->
				<div>
					<label for="name" class="block font-medium text-sm text-gray-700">
						{{ __('Name') }}
					</label>

					<input id="name" name="name" type="text" class="input input-bordered w-full" value="{{ old('name') }}" required autofocus>
				</div>

				<!-- Email Address -->
				<div class="mt-4">
					<label for="email" class="block font-medium text-sm text-gray-700">
						{{ __('Email') }}
					</label>

					<input id="email" name="email" type="email" class="input input-bordered w-full" value="{{ old('email') }}" required>
				</div>

				<!-- Password -->
				<div class="mt-4">
					<label for="password" class="block font-medium text-sm text-gray-700">
						{{ __('Password') }}
					</label>

					<input id="password" name="password" type="password" class="input input-bordered w-full" required autocomplete="new-password">
				</div>

				<!-- Confirm Password -->
				<div class="mt-4">
					<label for="password_confirmation" class="block font-medium text-sm text-gray-700">
						{{ __('Confirm Password') }}
					</label>

					<input id="password_confirmation" name="password_confirmation" type="password" class="input input-bordered w-full" required>
				</div>

				<div class="flex items-center justify-end mt-4">
					<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
						{{ __('Already registered?') }}
					</a>

					<button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
						{{ __('Register') }}
					</button>
				</div>
			</form>
		</div>
	</div>
@endsection
