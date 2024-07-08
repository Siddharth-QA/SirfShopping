<div class="col-xs-12 col-sm-12 col-lg-3 sidebar pr-lg-0 bg-white">
    <div class="side-menu animate-dropdown border h-100">
        <nav class="yamm megamenu-horizontal">
            <ul class="list-group">
                <li class="list-group-item {{ request()->is('user/order*') ? 'active' : '' }}">
                    <a style="{{ request()->is('user/order*') ? 'color:white' : '' }}" href="{{ route('order') }}">Orders</a>
                </li>                
                <li class="list-group-item {{ (request()->is('user/profile')) ? 'active' : '' }} "><a style="{{ (request()->is('user/profile')) ? 'color:white' : '' }}" href="{{ route('profile') }}" class="active">Profile</a>
                </li>
                <li class="list-group-item {{ (request()->is('user/address','user/add-create')) ? 'active' : '' }}"><a style="{{ (request()->is('user/address')) ? 'color:white' : '' }}" href="{{ route('address') }}">My Address</a>
                </li>
                <li class="list-group-item {{ (request()->is('user/change-password')) ? 'active' : '' }}">
                    <a style="{{ (request()->is('user/change-password')) ? 'color:white' : '' }}" href="{{ route('change.password') }}">Password Change</a>
                </li>
                <li class="list-group-item"><a  href="{{ route('user.logout') }}">Logout</a></li>
            </ul>
            <!-- /.nav -->
        </nav>
        <!-- /.megamenu-horizontal -->
    </div>
    <!-- /.side-menu -->
</div>