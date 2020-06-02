<div id="navigation-header" class="navigation-header fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                <span class="fa fa-gear"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img  src="/images/logo.footer.png"  alt="" width="200">
            </a>
        </div>
        <div>
            <ul class="nav-user">
                <li>
                    <p class="navbar-text">Group: <span>{!! Session::get('user')->getGroup->getGroupName() !!}</span></p>
                </li>
                <li>
                    <p class="navbar-text">Name: <span> {!! Session::get('user')->getFullName() !!}</span></p>
                </li>
                <li>
                    <a href="/cpanel/password"><i class="fas fa-key"></i>Change Password</a>
                </li>
                <li>
                    <a href="/cpanel/logout" ><i class="fas fa-door-open"></i><span>Logout</span></a>
                </li>
            </ul>
        </div>


    </div>

</div>
