<nav class="purple darken-4">
	<div class="{{ session('dir') == 'ltr' ? 'right' : 'left' }}">
		<ul>
			@foreach($languages as $language)
				<li style="padding:0 1px;"><a href="/{{ $language->slug }}">{{ $language->name }}</a></li>
			@endforeach
		</ul>
	</div>
</nav>
<nav class="top-nav">
	<div class="container">
		<a href="#" data-activates="nav-mobile2" class="button-collapse top-nav full hide-on-large-only {{ session('dir') == 'ltr' ? 'right' :  'left' }}"><i class="material-icons">menu</i></a>
	    <div class="nav-wrapper">
	      <a href="{{ url(session('slug')) }}" class="brand-logo {{ session('dir') == 'ltr' ? 'left' :  'right' }}">CMS</a>
	      <ul id="nav-mobile2" class="hide-on-med-and-down {{ session('dir') == 'ltr' ? 'right' :  'left' }}">
	        @include('partials.navigation', $menus)
	      </ul>
	    </div>
    </div>
 </nav>
 <div class="container"></div>
