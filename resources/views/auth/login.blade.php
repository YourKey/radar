@extends('layouts.app')
@section('content')
	<div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
		<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h1 class="card-title">Login</h1>
			<!-- Session Status -->
			<div class="mb-4 font-medium text-sm text-green-600">
				{{ session('status') }}
			</div>

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

			<form method="POST" action="{{ route('login') }}">
			@csrf

			<!-- Email Address -->
				<div>
					<label for="email" class="block font-medium text-sm text-gray-700">
						{{ __('Email') }}
					</label>

					<input id="email" name="email" type="email" class="input input-bordered w-full" value="{{ old('email') }}" required autofocus>
				</div>

				<!-- Password -->
				<div class="mt-4">
					<label for="password" class="block font-medium text-sm text-gray-700">
						{{ __('Password') }}
					</label>

					<input id="password" name="password" type="password" class="input input-bordered w-full" required autocomplete="current-password">
				</div>

				<!-- Remember Me -->
				<div class="block mt-4">
					<label for="remember_me" class="inline-flex items-center">
						<input id="remember_me" type="checkbox" class="checkbox" name="remember">
						<span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
					</label>
				</div>

				<div class="flex items-center justify-end mt-4">
					@if (Route::has('password.request'))
						<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
							{{ __('Forgot your password?') }}
						</a>
					@endif

					<button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
						{{ __('Log in') }}
					</button>
				</div>
			</form>
		</div>
	</div>
@endsection
