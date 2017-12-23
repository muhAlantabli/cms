<li class="{{ session('dir') == 'ltr' ? 'left' : 'right'}}"><a href="/{{ session('slug') }}" >{{ App\Language::translate('Home') }}</a></li>
@foreach($menus as $menu_item)
		
		@if(count($menu_item->children))
			<li class="{{ session('dir') == 'ltr' ? 'left' : 'right'}}">
				@if($menu_item->languages->find(session('lang_id')))
				<a href="{{ url('/')}}#" class="dropdown-button" data-activates="dropdown1" >{{ $menu_item->languages->find(session('lang_id'))->pivot->name }}</a>
				@else
					<a href="{{ url('/')}}#" class="dropdown-button" data-activates="dropdown1" >{{ $menu_item->languages->first()->pivot->name }}</a>
				@endif
				<ul id="dropdown1" class="dropdown-content">
				@foreach($menu_item->children as $child)
					@if($child->languages->find(session('lang_id')))
					<li><a href="{{ url(session('slug').'/'.App\Category::where('id', $child->category_id)->value('url')) }}">{{ $child->languages->find(session('lang_id'))->pivot->name }}</a></li>
					@else
						<li><a href="{{ url(session('slug').'/'.App\Category::where('id', $child->category_id)->value('url')) }}">{{ $child->languages->first()->pivot->name }}</a></li>
					@endif
				@endforeach
				</ul>
			</li>
		@else
			@if($menu_item->languages->find(session('lang_id')))
			<li class="{{ session('dir') == 'ltr' ? 'left' : 'right'}}"><a href="{{ $menu_item->type == 'parent' ? '' : url(session('slug').'/'.App\Category::where('id', $menu_item->category_id)->value('url')) }}">{{ $menu_item->languages->find(session('lang_id'))->pivot->name }}</a></li>
			@else
				<li class="{{ session('dir') == 'ltr' ? 'left' : 'right'}}"><a href="{{ $menu_item->type == 'parent' ? '' : url(session('slug').'/'.App\Category::where('id', $menu_item->category_id)->value('url')) }}">{{ $menu_item->languages->first()->pivot->name }}</a></li>
			@endif
		@endif
@endforeach


