@if(!empty($link))
    <li class="nav-item">
        <a href="{{$link}}" class="nav-link {{$activeLink}}">
            <i class="nav-icon fas {{$icon}}"></i>
            <p>{{$name}}</p>
        </a>
    </li>
@endif
