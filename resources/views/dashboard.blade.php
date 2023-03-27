@extends('layouts.app')

@section('content')
<div>
    <header class="flex justify-between py-6 pl-4 bg-white lg:pl-16">
        <div>
			<h3 class="text-lg font-bold lg:text-xl text-darkgreen">Welcome back, {{ Auth()->user()->name }}</h3>
			<p class="mt-2 text-sm lg:text-base">You’re on a roll, Keep on studying!</p>
		</div>
    </header>
    
    <div>
        <div class="px-8 py-12 pl-4 space-y-8 bg-gray-100 lg:pl-16">
			
        </div>
    </div>
    
</div>
@endsection


