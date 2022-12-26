<header class="d-flex white">
    <div class="list-sec d-flex">
        <a href="#" class='d-block list-icon'>
            <i class="fa-solid fa-bars"></i>
        </a>
        <div class='logout-icon'>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{auth()->user()->name}}
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">
                        <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                        <span>{{__('admin.edit_profile')}}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('admin.logout')}}">
                        <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                        <span>{{__('admin.logout')}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="search-sec">
        <div class="text-box">
            <input type="text" placeholder="{{__('admin.search')}}" />
            <span class="close"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <ul class="list-unstyled d-flex">
            <li>
                <a href="#" class="show-text-box"><i class="fas fa-magnifying-glass"></i></a>
            </li>
            <li>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <a href="#"><i class="fa-regular fa-bell"></i></a>
                        <span class="num-notification">5</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">
                            <span class="icon"><i class="fa-regular fa-flag"></i></span>
                            <span>{{__('admin.item_added')}}</span>
                            <span class="time">3 {{__('admin.minites')}}</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <span class="icon"><i class="fa-regular fa-flag"></i></span>
                            <span>{{__('admin.user_added')}}</span>
                            <span class="time">4 {{__('admin.hours')}}</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <span class="icon"><i class="fa-regular fa-flag"></i></span>
                            <span>{{__('admin.category_added')}}</span>
                            <span class="time">2 {{__('admin.days')}}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <span class="icon"><i class="fa-regular fa-flag"></i></span>
                            <span>{{__('admin.see_all_notifications')}}</span>
                        </a>
                    </div>
                </div>
            </li>
            <li><a href="#" class="full-screen"><i class="fa-solid fa-expand"></i></a></li>
        </ul>
    </div>
</header>