<li><a href="{{ url('/') }}">Home</a></li>
@foreach($menus as $menu_item)
		
		@if(count($menu_item->children))
			<li>
				<a href="{{ url('/')}}#" class="dropdown-button" data-activates="dropdown1" >{{ $menu_item->name }}</a>
				<ul id="dropdown1" class="dropdown-content">
				@foreach($menu_item->children as $child)
					<li><a href="{{ route(App\Category::where('id', $child->category_id)->value('title')) }}">{{ $child->name }}</a></li>
				@endforeach
				</ul>
			</li>
		@else
			<li><a href="{{ $menu_item->type == 'parent' ? '' : route(App\Category::where('id', $menu_item->category_id)->value('title')) }}">{{ $menu_item->name }}</a></li>
		@endif
@endforeach
