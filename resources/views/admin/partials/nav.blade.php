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
                <a href="#!user"><img class="circle" src="{{ url('/') }}/images/m.jpg"></a>
                <a href="#!name"><span class="white-text name">John Doe</span></a>
                <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
            </div>
        </li>

        <li>
            <a href="#" class="waves-effect waves-teal">Dashboard</a>
        </li>

        <li><a href="#" class="waves-effect waves-teal">Users</a></li>
        <li><a href="#" class="waves-effect waves-teal">Permissions</a></li>

        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header waves-effect waves-teal">
                        
                        <span style="padding-left: 16px;">Settings</span>
                        
                    </a>
                    <div class="collapsible-body" style="padding-left: 16px;">
                        <ul>
                            <li><a href="#">Languages</a></li>
                            <li><a href="#">Layouts</a></li>
                            <li><a href="#">Fixed Fields</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li class="bold"><a href="{{ route('menus.index') }}" class="waves-effect waves-teal">Menus</a></li>
        <li><a href="#" class="waves-effect waves-teal">Comments</a></li>
        <li><a href="#" class="waves-effect waves-teal">Tags</a></li>
        <li class="bold"><a href="{{ route('categories.index') }}" class="waves-effect waves-teal">Categories</a></li>
        
    </ul>

</header>