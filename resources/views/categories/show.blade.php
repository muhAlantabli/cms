@extends('layouts.main_admin')


@section('content')
	<div class="container">
		<h2>{{ $category->title }}</h2>

		<p>Image:</p>
		<img src="/images/{{ $category->image }}">


	</div>

@endsection