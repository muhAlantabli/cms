@extends('layouts.main_admin')

@section('title', 'Attach Role')

@section('content')

	<div class="container">
		<h5>{{ $title }}</h5>

		<form action="{{ route('users.store') }}" method="POST">
			{{ csrf_field() }}
		     
			<div class="col s12">
				<div class="input-field" style="padding-top: 20px;">
				    <select class="icons" name="user_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($users as $user)
						<option value="{{ $user->id }}">{{ $user->name }}</option>
				      @endforeach
				      
				    </select>
				    <label for="user_id">User</label>
				</div>

				<div class="input-field" style="padding-top: 20px;">
				    <select class="icons" name="role_id">
				      <option value="" disabled selected>Choose your option</option>
				      @foreach($roles as $role)
						<option value="{{ $role->id }}">{{ $role->name }}</option>
				      @endforeach
				      
				    </select>
				    <label for="role_id">Role</label>
				</div>
				
			</div>
			
			<div style="padding-top: 20px;">
					<button type="submit" class="btn waves-effect waves-light large">Submit</button>	
			</div>
		</form>
	</div>

@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			$('select').material_select();
		});	
	</script>


@endsection
