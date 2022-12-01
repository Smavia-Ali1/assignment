<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{url('/index')}}" class="fa fa-circle">  Task Management</a>
            </li>
            <li>
                <a href="{{ route('logout') }}" class="fa fa-circle" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">  Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
</aside>
