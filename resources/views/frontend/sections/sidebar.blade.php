<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li>
                {{-- <a href="{{url('/index')}}" class="fa fa-circle">  Task Management</a> --}}
                <a href="{{ route('viewallTasks') }}" class="fa fa-circle">  Task Management</a>
            </li>
            <li>
                <a href="{{ url('my/tasks') }}" class="fa fa-circle">   My Tasks</a>
            </li>
            <li>
                <a href="javascript:void(0)" class="fa fa-circle" id="logout-form">  Sign out</a>
                {{-- <a href="{{ route('logout') }}" class="fa fa-circle" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">  Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form> --}}
            </li>
        </ul>
    </section>
</aside>
