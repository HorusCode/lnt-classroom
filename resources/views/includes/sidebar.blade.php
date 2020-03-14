<aside class="sidebar">
    <header class="sidebar__header d-flex justify-content-between align-items-center">
        <div class="logo">
            <img src="" alt="Logo" width="50" height="50" class="logo--image">
        </div>
        <div class="burger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>
    <div class="sidebar__content">
        <ul class="sidebar__nav-menu vertical-list">
            <li class="vertical-list__heading">Меню</li>
            <li class="vertical-list__item --active">
                <a href="#" aria-expanded="true">
                    <span class="mdi mdi-account-group pos-left-null"></span>
                    Студенты
                    <span class="mdi mdi-chevron-up pos-right-null"></span>
                </a>
                <ul class="submenu">
                    @php
                        $route = Route::currentRouteName();
                    @endphp
                    <li class="submenu__item">
                        <a class="{{ $route === 'teacher.add-students' ? 'active' : ''}}"
                           href="{{ route('teacher.add-students') }}">Добавить</a>
                    </li>
                    <li class="submenu__item">
                        <a class="{{ $route === 'teacher.view-student' ? 'active' : '' }}"
                           href="{{ route('teacher.view-students') }}">Просмотреть</a>
                    </li>
                </ul>
            </li>
            <li class="vertical-list__item">
                <a href="#" aria-expanded="true">
                    <span class="mdi mdi-group pos-left-null"></span>
                    Группы
                </a>
            </li>
            <li class="vertical-list__item --active">
                <a href="#" aria-expanded="true">
                    <span class="mdi mdi-book-multiple pos-left-null"></span>
                    Курсы
                    <span class="mdi mdi-chevron-up pos-right-null"></span>
                </a>
                <ul class="submenu">
                    @php
                        $route = Route::currentRouteName();
                    @endphp
                    <li class="submenu__item">
                        <a class="{{ $route === 'home' ? 'active' : ''}}"
                           href="">Создать</a>
                    </li>
                    <li class="submenu__item">
                        <a class="{{ $route === 'active' ? 'active' : '' }}"
                           href="">Просмотреть</a>
                    </li>
                </ul>
            </li>
            <li class="vertical-list__item --active">
                <a href="{{ route('test.tests') }}" aria-expanded="true">
                    <span class="mdi mdi-checkbox-multiple-blank pos-left-null"></span>
                    Тесты
                </a>
            </li>
            <li class="vertical-list__item">
                <a href="#" aria-expanded="true">
                    <span class="mdi mdi-chart-histogram pos-left-null"></span>
                    Статистика
                </a>
            </li>
        </ul>
    </div>
    <header class="sidebar__footer d-flex justify-content-center align-items-center">
        <a class="btn btn-primary is-extended" href="{{ route('logout')}}">Выход</a>
    </header>
</aside>
