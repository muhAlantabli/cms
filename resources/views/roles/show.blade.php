@extends('layouts.main_admin')

@section('title', $role->name)

@section('content')
	<div class="row" style="padding-top: 50px;">
		<div class="col s8">
			<form action="{{ route('roles.addpermissions') }}" method="POST">
				{{ csrf_field() }}
				<div>
					<input type="hidden" name="role_id" value="{{ $role->id }}">
					<p>
				      <input type="checkbox" id="create.category" name="create.category" />
				      <label for="create.category">Create Category</label>
				    </p>

				    <p>
				      <input type="checkbox" id="edit.category" name="edit.category" />
				      <label for="edit.category">Edit Category</label>
				    </p>

				    <p>
				      <input type="checkbox" id="show.category" name="show.category" />
				      <label for="show.category">show Category</label>
				    </p>

				    <p>
				      <input type="checkbox" id="delete.category" name="delete.category" />
				      <label for="delete.category">delete Category</label>
				    </p>

				    <p>
				      <input type="checkbox" id="create.item" name="create.item" />
				      <label for="create.item">Create Item</label>
				    </p>

				    <p>
				      <input type="checkbox" id="edit.item" name="edit.item" />
				      <label for="edit.item">Edit Item</label>
				    </p>

				    <p>
				      <input type="checkbox" id="show.item" name="show.item" />
				      <label for="show.item">show Item</label>
				    </p>

				    <p>
				      <input type="checkbox" id="delete.item" name="delete.item" />
				      <label for="delete.item">delete Item</label>
				    </p>

				    <p>
				      <input type="checkbox" id="create.menu" name="create.menu" />
				      <label for="create.menu">Create Menu</label>
				    </p>

				    <p>
				      <input type="checkbox" id="edit.menu" name="edit.menu" />
				      <label for="edit.menu">Edit Menu</label>
				    </p>

				    <p>
				      <input type="checkbox" id="show.menu" name="show.menu" />
				      <label for="show.menu">show Menu</label>
				    </p>

				    <p>
				      <input type="checkbox" id="delete.menu" name="delete.menu" />
				      <label for="delete.menu">delete Menu</label>
				    </p>

				    <p>
				      <input type="checkbox" id="add.extrafield" name="add.extrafield" />
				      <label for="add.extrafield">add Extra Field</label>
				    </p>

				    <p>
				      <input type="checkbox" id="show.extrafield" name="show.extrafield" />
				      <label for="show.extrafield">show Extra Field</label>
				    </p>

				    <p>
				      <input type="checkbox" id="delete.extrafield" name="delete.extrafield" />
				      <label for="delete.extrafield">delete Extra Field</label>
				    </p>

				    <p>
				      <input type="checkbox" id="add.language" name="add.language" />
				      <label for="add.language">Create Language</label>
				    </p>

				    <p>
				      <input type="checkbox" id="delete.language" name="delete.language" />
				      <label for="delete.language">delete Language</label>
				    </p>

				    <p>
				      <input type="checkbox" id="translate.text" name="transaate.text" />
				      <label for="translate.text">Translate Text</label>
				    </p>

				    <p>
				      <input type="checkbox" id="delete.text" name="delete.text" />
				      <label for="delete.text">delete Text</label>
				    </p>

				    <p>
				      <input type="checkbox" id="delete.comment" name="delete.comment" />
				      <label for="delete.comment">delete Comment</label>
				    </p>

				    <p>
				      <input type="checkbox" id="add.tag" name="add.tag" />
				      <label for="add.tag">Add Tag</label>
				    </p>

				    <p>
				      <input type="checkbox" id="delete.tag" name="delete.tag" />
				      <label for="delete.tag">Delete Tag</label>
				    </p>

				    <p>
				      <input type="checkbox" id="show.tag" name="show.tag" />
				      <label for="show.tag">Show Tag</label>
				    </p>



				</div>
				<div style="padding-top: 20px;">
					<button type="submit" class="btn">Submit</button>
				</div>
				
			</form>	
		</div>

		<div class="col s4">
		<div class="card">
            <div class="card-content">
				<h4>Assigned Permissions</h4>
              <ul>
              	@foreach($permissions as $permission)
					<li>{{ $permission['name'] }}</li>
              	@endforeach
              </ul>             

            </div>
            
		</div>
	</div>
			
	</div>
	
@endsection

