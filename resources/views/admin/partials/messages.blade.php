
@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			@if(count($errors))
				@foreach($errors->all() as $error)
	   				Materialize.toast('{{ $error }}', 4000, 'rounded')
	   			 @endforeach
   			 @endif

   			 @if(Session::has('success'))
   			 	Materialize.toast('{{ Session::get('success') }}', 4000, 'rounded')
   			 @endif
		});	
	</script>

@endsection