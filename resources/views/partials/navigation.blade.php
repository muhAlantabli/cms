<li><a href="/{{ session('slug') }}">Home</a></li>
@foreach($menus as $menu_item)
		
		@if(count($menu_item->children))
			<li>
				<a href="{{ url('/')}}#" class="dropdown-button" data-activates="dropdown1" >{{ $menu_item->languages->find(session('lang_id'))->pivot->name }}</a>
				<ul id="dropdown1" class="dropdown-content">
				@foreach($menu_item->children as $child)
					<li><a href="{{ url(session('slug').'/'.App\Category::where('id', $child->category_id)->value('url')) }}">{{ $child->languages->find(session('lang_id'))->pivot->name }}</a></li>
				@endforeach
				</ul>
			</li>
		@else
			<li><a href="{{ $menu_item->type == 'parent' ? '' : url(session('slug').'/'.App\Category::where('id', $menu_item->category_id)->value('url')) }}">{{ $menu_item->languages->find(session('lang_id'))->pivot->name }}</a></li>
		@endif
@endforeach
