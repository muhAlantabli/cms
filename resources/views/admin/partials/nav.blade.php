<header>
    <nav class="purple darken-4">
        <div style="font-size: xx-large;">&nbsp Dashboard</div>
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
            <a href="#" class="waves-effect waves-teal"><i class="material-icons">dashboard</i>Dashboard</a>
        </li>

        <li><a href="#" class="waves-effect waves-teal"><i class="material-icons">person</i>Users</a></li>
        <li><a href="#" class="waves-effect waves-teal"><i class="material-icons">security</i>Permissions</a></li>

        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header waves-effect waves-teal">
                        <i class="material-icons" style="padding-left: 16px;">settings</i>
                        <span style="padding-left: 16px;">Settings</span>
                        <i class="material-icons right" >arrow_drop_down</i>
                    </a>
                    <div class="collapsible-body" style="padding-left: 16px;">
                        <ul>
                            <li><a href="#"><i class="material-icons">language</i>Languages</a></li>
                            <li><a href="#"><i class="material-icons">layers</i>Layouts</a></li>
                            <li><a href="#"><i class="material-icons">filter_none</i>Fixed Fields</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li class="bold"><a href="#" class="waves-effect waves-teal"><i class="material-icons">pages</i>Pages</a></li>
        <li><a href="#" class="waves-effect waves-teal"><i class="material-icons">comment</i>Comments</a></li>
        <li><a href="#" class="waves-effect waves-teal"><i class="material-icons">format_quote</i>Tags</a></li>
        <li class="bold"><a href="#" class="waves-effect waves-teal"><i class="material-icons">library_books</i>Categories</a></li>
        <li class="bold"><a href="#" class="waves-effect waves-teal"><i class="material-icons">extension</i>Items</a></li>
    </ul>

</header>