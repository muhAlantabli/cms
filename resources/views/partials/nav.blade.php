<nav class="purple darken-4">
	<div class="right">
		<ul>
			@foreach($languages as $language)
				<li style="padding:0 1px;"><a href="/{{ $language->slug }}">{{ $language->name }}</a></li>
			@endforeach
		</ul>
	</div>
</nav>
<nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo left">CMS</a>
      <ul id="nav-mobile" class="hide-on-med-and-down right">
        @include('partials.navigation', $menus)
      </ul>
    </div>
 </nav>
