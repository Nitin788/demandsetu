<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="{{asset('./assets/img/admin-avatar.png')}}" width="45px">
            </div>
            <div class="admin-info">
                <div class="font-strong">
                    {{ Auth::user()->name }}
                </div><small> {{ Auth::user()->email }}</small>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li>
                <a class="active" href="{{route('dashboard')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">Homre Page</li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                    <span class="nav-label">Home Page</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse" aria-expanded="false">
                    <li>
                        <a href="{{route('homepages.create')}}">Add Home Page Data</a>
                    </li>
                    <li>
                        <a href="{{route('homepages.index')}}">Home Page List</a>
                    </li>
                    <!-- <li>
                        <a href="#">Panels</a>
                    </li>
                    <li>
                        <a href="#">Buttons</a>
                    </li>
                    <li>
                        <a href="#">Tabs</a>
                    </li>
                    <li>
                        <a href="#">Alerts & Tooltips</a>
                    </li>
                    <li>
                        <a href="#">Badges & Progress</a>
                    </li>
                    <li>
                        <a href="#">List</a>
                    </li>
                    <li>
                        <a href="#">Card</a>
                    </li> -->
                </ul>
            </li>
            <li class="heading">Destination Type And Places</li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-edit"></i>
                    <span class="nav-label">Destinations</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse" aria-expanded="false">
                    <li>
                        <a href="{{route('countries.create')}}">Destination Type</a>
                    </li>
                    <li>
                        <a href="{{route('countries.index')}}">Destination List</a>
                    </li>
                    <li>
                        <a href="{{route('destinations.create')}}">Add Destination</a>
                    </li>
                    <li>
                        <a href="{{route('destinations.index')}}">Destination List</a>
                    </li>
                    <!-- <li>
                        <a href="#">Text Editors</a>
                    </li> -->
                </ul>
            </li>
            <li class="heading">Places</li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-table"></i>
                    <span class="nav-label">Places</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse" aria-expanded="false">
                    <li>
                        <a href="{{route('places.create')}}">Add Place</a>
                    </li>
                    <li>
                        <a href="{{route('places.index')}}">Place List</a>
                    </li>
                </ul>
            </li>
            <!-- <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-bar-chart"></i>
                    <span class="nav-label">Charts</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse" aria-expanded="false">
                    <li>
                        <a href="#">Flot Charts</a>
                    </li>
                    <li>
                        <a href="#">Morris Charts</a>
                    </li>
                    <li>
                        <a href="#">Chart.js</a>
                    </li>
                    <li>
                        <a href="#">Sparkline Charts</a>
                    </li>
                </ul>
            </li> -->
            <!-- <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-map"></i>
                    <span class="nav-label">Maps</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse" aria-expanded="false">
                    <li>
                        <a href="#">Vector maps</a>
                    </li>
                </ul>
            </li> -->
            <!-- <li>
                <a href="#"><i class="sidebar-item-icon fa fa-smile-o"></i>
                    <span class="nav-label">Icons</span>
                </a>
            </li> -->
            <!-- <li class="heading">PAGES</li> -->
            <!-- <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-envelope"></i>
                    <span class="nav-label">Mailbox</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse" aria-expanded="false">
                    <li>
                        <a href="#">Inbox</a>
                    </li>
                    <li>
                        <a href="#">Mail view</a>
                    </li>
                    <li>
                        <a href="#">Compose mail</a>
                    </li>
                </ul>
            </li> -->
            <!-- <li>
                <a href="#"><i class="sidebar-item-icon fa fa-calendar"></i>
                    <span class="nav-label">Calendar</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                    <span class="nav-label">Pages</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse" aria-expanded="false">
                    <li>
                        <a href="#">Invoice</a>
                    </li>
                    <li>
                        <a href="#">Profile</a>
                    </li>
                    <li>
                        <a href="#">Login</a>
                    </li>
                    <li>
                        <a href="#">Register</a>
                    </li>
                    <li>
                        <a href="#">Lockscreen</a>
                    </li>
                    <li>
                        <a href="#">Forgot password</a>
                    </li>
                    <li>
                        <a href="#">404 error</a>
                    </li>
                    <li>
                        <a href="#">500 error</a>
                    </li>
                </ul>
            </li> -->
            <!-- <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-sitemap"></i>
                    <span class="nav-label">Menu Levels</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse" aria-expanded="false">
                    <li>
                        <a href="javascript:;">Level 2</a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="nav-label">Level 2</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-3-level collapse" aria-expanded="false">
                            <li>
                                <a href="javascript:;">Level 3</a>
                            </li>
                            <li>
                                <a href="javascript:;">Level 3</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> -->
        </ul>
    </div>
</nav>