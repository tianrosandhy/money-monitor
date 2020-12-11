<ul class="metismenu" id="menu-bar">
    @foreach($sidebar as $key => $sidedata)
        @if($sidedata->getRoute())
            @if(!Permission::has($sidedata->getRoute()))
                @continue
            @endif
        @endif
        <li class="{{ in_array($selected_menu, $sidedata->getActiveKey()) ? 'mm-active' : '' }}">
            <a href="{{ $sidedata->getChildren() ? '#' : $sidedata->url() }}">
                @if($sidedata->getIcon())
                <i data-feather="{{ $sidedata->getIcon() }}"></i>
                @endif
                <span> {{ $sidedata->getLabel() }} </span>
                @if($sidedata->getChildren())
                <span class="menu-arrow"></span>
                @endif
            </a>
            @if($sidedata->getChildren())
            <ul class="nav-second-level" aria-expanded="false">
                @foreach($sidedata->getChildren() as $subkey => $subdata)
                    @if($subdata->getRoute())
                        @if(!Permission::has($subdata->getRoute()))
                            @continue
                        @endif
                    @endif
                    <li class="{{ in_array($selected_menu, $subdata->getActiveKey()) ? 'mm-active' : '' }}">
                        <a href="{{ $subdata->getChildren() ? '#' : $subdata->url() }}">
                            @if($subdata->getIcon())
                            <i data-feather="{{ $subdata->getIcon() }}"></i>
                            @endif
                            <span>{{ $subdata->getLabel() }}</span>
                            @if($subdata->getChildren())
                            <span class="menu-arrow"></span>
                            @endif
                        </a>
                        @if($subdata->getChildren())
                        <ul class="nav-third-level" aria-expanded="false">
                            @if($subdata->getChildren())
                            @foreach($subdata->getChildren() as $thirdkey => $thirddata)
                                @if($thirddata->getRoute())
                                    @if(!Permission::has($thirddata->getRoute()))
                                        @continue
                                    @endif
                                @endif
                                <li class="{{ in_array($selected_menu, $thirddata->getActiveKey()) ? 'mm-active' : '' }}">
                                    <a href="{{ $thirddata->url() }}">
                                        @if($thirddata->getIcon())
                                        <i data-feather="{{ $thirddata->getIcon() }}"></i>
                                        @endif
                                        <span>{{ $thirddata->getLabel() }}</span>
                                    </a>
                                </li>
                            @endforeach
                            @endif
                        </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
            @endif
        </li>
    @endforeach
</ul>