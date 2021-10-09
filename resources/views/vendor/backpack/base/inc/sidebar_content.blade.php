<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item nav-dropdown">
<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-tablet"></i><b><i>Tables</i></b></a>
<ul class="nav-dropdown-items">
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('tag') }}'><i class='nav-icon la la-question'></i> Tags</a></li> --}}
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('post') }}'><i class='nav-icon  la la-envelope'></i> Posts</a></li>
<li class='nav-item '><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon  la la la-users'></i> Users</a></li>
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('man') }}'><i class='nav-icon la la-question'></i> Men</a></li> --}}
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('comment') }}'><i class='nav-icon la la-comment'></i> Comments</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon  la la-certificate'></i> Categories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('favorite') }}'><i class='nav-icon  la la-heart-o'></i> Favorites</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('rate') }}'><i class='nav-icon la  la-bar-chart'></i> Rates</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('video') }}'><i class='nav-icon  la la-video-camera'></i> Videos</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('serie') }}'><i class='nav-icon  la la-forward'></i> Series</a></li>
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('article') }}'><i class='nav-icon la la-question'></i> Articles</a></li> --}}

</ul>
</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('type') }}'><i class='nav-icon la la-question'></i> Types</a></li>