<li class="side-nav-item">
    <a data-bs-toggle="collapse" href="#sidebarMultiLevel" aria-expanded="false" aria-controls="sidebarMultiLevel" class="side-nav-link">
        <i class="uil-layer-group"></i>
        <span> Админ </span>
        <span class="menu-arrow"></span>
    </a>
    <div class="collapse" id="sidebarMultiLevel">
        <ul class="side-nav-second-level">
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSecondLevel" aria-expanded="false" aria-controls="sidebarSecondLevel">
                    <span> Пользователи </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSecondLevel">
                    <ul class="side-nav-third-level">
                        <li>
                            <a href="{{ route('users.index') }}">Список</a>
                        </li>
                        <li>
                            <a href="{{ route('roles.index') }}">Роли</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#">Menu1</a>
            </li>

            {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarThirdLevel" aria-expanded="false" aria-controls="sidebarThirdLevel">
                    <span> Third Level </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarThirdLevel">
                    <ul class="side-nav-third-level">
                        <li>
                            <a href="javascript: void(0);">Item 1</a>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarFourthLevel" aria-expanded="false" aria-controls="sidebarFourthLevel">
                                <span> Item 2 </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarFourthLevel">
                                <ul class="side-nav-forth-level">
                                    <li>
                                        <a href="javascript: void(0);">Item 2.1</a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);">Item 2.2</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li> --}}
        </ul>
    </div>
</li>
