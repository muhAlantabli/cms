<header>
    <nav class="purple darken-4">
        <div style="font-size: xx-large;">&nbsp; @yield('title')</div>
    </nav>
    <ul class="side-nav fixed">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="{{ url('/') }}/images/user-view-bg.jpg">
                </div>
                <a href="#!user"><img class="circle" src="{{ url('/') }}/images/admin.png"></a>
                <a href="#!name"><span class="white-text name">{{ auth()->user()->name }}</span></a>
                <a href="#!email"><span class="white-text email">{{ auth()->user()->email }}</span></a>
            </div>
        </li>

        <li>
            <a href="#" class="waves-effect waves-teal">Dashboard</a>
        </li>

        <li><a href="#" class="waves-effect waves-teal">Users</a></li>
        <li><a href="#" class="waves-effect waves-teal">Languages</a></li>
        
        <li class="bold"><a href="{{ route('menus.index') }}" class="waves-effect waves-teal">Menus</a></li>
        <li><a href="{{ route('comments.index') }}" class="waves-effect waves-teal">Comments</a></li>
        <li><a href="{{ route('tags.index') }}" class="waves-effect waves-teal">Tags</a></li>
        <li class="bold"><a href="{{ route('categories.index') }}" class="waves-effect waves-teal">Categories</a></li>
        
    </ul>

</header>