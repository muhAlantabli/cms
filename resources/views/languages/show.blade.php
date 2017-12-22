@extends('layouts.main_admin')


@section('content')
	<div class="row">
		
		<div class="col s8">
			<ul class="collapsible" data-collapsible="accordion">
				<li>
					<div class="collapsible-header active"><strong>Name</strong></div>
					<div class="collapsible-body">{{ $language->name }}</div>
				</li>

				<li>
					<div class="collapsible-header"><strong>Direction</strong></div>
					<div class="collapsible-body">{{ $language->dir}}</div>
				</li>

				<li>
					<div class="collapsible-header"><strong>Slug</strong></div>
					<div class="collapsible-body">{!! $language->slug !!}</div>
				</li>
			</ul>
		</div>
	
	<div class="col s8" style="padding-top: 50px;">
		<a class="waves-effect waves-light btn" href="{{ route('languages.translate', $language->id) }}">Translate Text</a>
		<table class="bordered highlight">
			<thead>
				<tr>
					<th>#</th>
					<th>Text</th>
					<th>Translated Text</th>
					<th></th>
					
				</tr>
			</thead>

			<tbody>
					@foreach($dictionaryTexts as $text)
					<tr>
						<td>{{ $text->id }}</td>
						<td>{{ $text->text }}</td>
						<td>{{ $text->translated_text }}</td>
						
						<td class="right">
						<form action="{{ url('/delete_text/'.$language->id.'/'.$text->id) }}" method="POST">
							<input type="hidden" name="_method" value="DELETE">
    						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button class="waves-effect waves-light btn red tiny" type="submit">Delete</button>	
						</form>
						</td>
					</tr>
					@endforeach
				
			</tbody>
		</table>	
	</div>
@endsection


@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
    		$('.collapsible').collapsible();
  		});	
	</script>
@endsection