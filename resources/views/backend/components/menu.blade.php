<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        @if(mainSettingsData() != null)
        <a href="{{ route('home') }}"><img src="{{ asset('uploads/backend/settings/'.mainSettingsData()['logo']) }}" alt="{{ mainSettingsData()['title'] }}" class="img-fluid logo"><span>{{ transWord('Dashboard') }}</span></a>
        @else
        <a href="{{ route('home') }}"><img src="{{ asset('dashboard/assets/images/icon.svg') }}" alt="{{ transWord('Dashboard') }}" class="img-fluid logo"><span>{{ transWord('Dashboard') }}</span></a>
        @endif
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu icon-close"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                <img src="{{ asset('uploads/backend/users/'.Auth::user()->avatar) }}" class="user-photo" alt="User Profile Picture">
            </div>
            <div class="dropdown">
                <span>{{ transWord('Welcome') }}</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ Auth::user()->name }}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                    <li><a href="{{ route('profile_users') }}"><i class="icon-user"></i>{{ transWord('My Profile') }}</a></li>
                    <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="icon-power"></i> {{ __('tr.Logout') }}
                    </a>

                    <form id="logout-form" action="" method="POST" style="display: none;">
                        @csrf
                    </form></li>
                </ul>
            </div>                
        </div>  
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                <li class="header">{{ transWord('Main') }}</li>
                <li class="{{ menuActive('roles',3) }}"><a href="{{ route('roles') }}"><i class="icon-user-follow"></i><span>{{ transWord('Roles') }}</span></a></li>
                <li class="{{ menuActive('permissions',3) }}"><a href="{{ route('permissions') }}"><i class="icon-shield"></i><span>{{ transWord('Permissions') }}</span></a></li>
                <li class="{{ menuActive('users',3) }}">
                    <a href="#myPage" class="has-arrow"><i class="icon-users"></i><span>{{ transWord('Users') }}</span></a>
                    <ul>
                        <li><a href="{{ route('create_users') }}">{{ transWord('Create New User') }}</a></li>
                        <li><a href="{{ route('users') }}">{{ transWord('All Users') }}</a></li>
                    </ul>
                </li>
                <li class="{{ menuActive('pages',3) }}">
                    <a href="#myPage" class="has-arrow"><i class="icon-book-open"></i><span>{{ transWord('Pages') }}</span></a>
                    <ul>
                        <li><a href="{{ route('create_pages') }}">{{ transWord('Create New Page') }}</a></li>
                        <li><a href="{{ route('pages') }}">{{ transWord('All Pages') }}</a></li>
                    </ul>
                </li>
                <li class="{{ menuActive('blogs',3) }}">
                    <a href="#myPage" class="has-arrow"><i class="icon-notebook"></i><span>{{ transWord('Blogs') }}</span></a>
                    <ul>
                        <li><a href="{{ route('create_blogs') }}">{{ transWord('Create New Blog') }}</a></li>
                        <li><a href="{{ route('blogs') }}">{{ transWord('All Blogs') }}</a></li>
                    </ul>
                </li>
                

                <li class="header">{{ transWord('Contacts') }}</li>
                <li class="{{ menuActive('contacts',3) }}"><a href="{{ route('contacts') }}"><i class="icon-envelope"></i><span>{{ transWord('Contact Us') }}</span></a></li>


                <li class="header">{{ transWord('Settings') }}</li>
                <li class="{{ menuActive('mainsettings',3) }}"><a href="{{ route('mainsettings') }}"><i class="icon-settings"></i><span>{{ transWord('Main Settings') }}</span></a></li>
                <li class="{{ menuActive('langs',3) }}"><a href="{{ route('langs') }}"><i class="fa fa-language"></i><span>{{ transWord('Languages') }}</span></a></li>
                {{-- <li class="{{ menuActive('mainsettings',3) }}"><a href="{{ route('exports',['model'=>'\App\User','name'=>'users']) }}"><i class="icon-excel"></i><span>{{ transWord('Export') }}</span></a></li> --}}
                
                
            </ul>
        </nav>     
    </div>
</div>