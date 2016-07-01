<!-- Authentication Links -->
@if (Auth::guest())
    <li><a href="{{ url('/login') }}">Login</a></li>
    <li><a href="{{ url('/register') }}">Register</a></li>
@else
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
            </li>
            @if (Auth::user()->hasRole('admin'))
                <li class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" id="adminMenu" data-toggle="dropdown">
                        Admin
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="adminMenu">
                        <li>
                            <a href="{{ route('admin.index') }}">Panel</a>
                        </li>
                        <li role="presentation" class="dropdown-header">User</li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="{{ route('admin.user.index') }}">Index</a>
                            <a role="menuitem" tabindex="-1" href="{{ route('admin.user.create') }}">New</a>

                            <button class="btn btn-default dropdown-toggle" type="button" id="teamsMenu" data-toggle="dropdown">
                                Teams
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="teamsMenu">
                                <li role="presentation" class="dropdown-header">Teams</li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ route('teams.index') }}">Index</a>
                                    <a role="menuitem" tabindex="-1" href="{{ route('teams.create') }}">New</a>
                                </li>
                            </ul>
                        </li>
                  </ul>
                </li>
            <!-- End Admin section -->
            @endif
        </ul>
    </li>
@endif