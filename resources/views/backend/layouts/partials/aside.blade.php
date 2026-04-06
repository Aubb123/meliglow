<aside id="layout-menu" class="layout-menu menu-vertical menu">

    <div class="app-brand demo ">
    <a href="index.html.htm" class="app-brand-link">
        <span class="app-brand-logo demo">
        <span class="text-primary">
            <svg width="32" height="18" viewBox="0 0 38 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M30.0944 2.22569C29.0511 0.444187 26.7508 -0.172113 24.9566 0.849138C23.1623 1.87039 22.5536 4.14247 23.5969 5.92397L30.5368 17.7743C31.5801 19.5558 33.8804 20.1721 35.6746 19.1509C37.4689 18.1296 38.0776 15.8575 37.0343 14.076L30.0944 2.22569Z" fill="currentColor"></path>
            <path d="M30.171 2.22569C29.1277 0.444187 26.8274 -0.172113 25.0332 0.849138C23.2389 1.87039 22.6302 4.14247 23.6735 5.92397L30.6134 17.7743C31.6567 19.5558 33.957 20.1721 35.7512 19.1509C37.5455 18.1296 38.1542 15.8575 37.1109 14.076L30.171 2.22569Z" fill="url(#paint0_linear_2989_100980)" fill-opacity="0.4"></path>
            <path d="M22.9676 2.22569C24.0109 0.444187 26.3112 -0.172113 28.1054 0.849138C29.8996 1.87039 30.5084 4.14247 29.4651 5.92397L22.5251 17.7743C21.4818 19.5558 19.1816 20.1721 17.3873 19.1509C15.5931 18.1296 14.9843 15.8575 16.0276 14.076L22.9676 2.22569Z" fill="currentColor"></path>
            <path d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z" fill="currentColor"></path>
            <path d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z" fill="url(#paint1_linear_2989_100980)" fill-opacity="0.4"></path>
            <path d="M7.82901 2.22569C8.87231 0.444187 11.1726 -0.172113 12.9668 0.849138C14.7611 1.87039 15.3698 4.14247 14.3265 5.92397L7.38656 17.7743C6.34325 19.5558 4.04298 20.1721 2.24875 19.1509C0.454514 18.1296 -0.154233 15.8575 0.88907 14.076L7.82901 2.22569Z" fill="currentColor"></path>
            <defs>
                <linearGradient id="paint0_linear_2989_100980" x1="5.36642" y1="0.849138" x2="10.532" y2="24.104" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-opacity="1"></stop>
                <stop offset="1" stop-opacity="0"></stop>
                </linearGradient>
                <linearGradient id="paint1_linear_2989_100980" x1="5.19475" y1="0.849139" x2="10.3357" y2="24.1155" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-opacity="1"></stop>
                <stop offset="1" stop-opacity="0"></stop>
                </linearGradient>
            </defs>
            </svg>
        </span>
        </span>
        <span class="app-brand-text demo menu-text fw-semibold ms-2">{{ config('app.name') }}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z" fill-opacity="0.9"></path>
        <path d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z" fill-opacity="0.4"></path>
        </svg>
    </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item 
            @if(in_array(Route::currentRouteName(), [
                'backend.index',
                'backend.continents.index', 'backend.continents.show', 'backend.continents.edit', 'backend.continents.countries',
                'backend.countries.index', 'backend.countries.show', 'backend.countries.edit',
            ])) active open @endif 
        ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-home-9-fill"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
            <ul class="menu-sub">

                <!-- Cloud Platforms -->
                <li class="menu-item 
                    @if(in_array(Route::currentRouteName(), [
                        'backend.cloud_platforms.index', 'backend.cloud_platforms.show',
                    ])) active open @endif
                ">
                    <a href="{{ route('backend.cloud_platforms.index') }}" class="menu-link">
                        <div data-i18n="Cloud Platforms">Cloud Platforms</div>
                    </a>
                </li>

                <li class="menu-item 
                    @if(in_array(Route::currentRouteName(), [
                        'backend.continents.index', 'backend.continents.show', 'backend.continents.edit', 'backend.continents.countries',
                    ])) active open @endif
                ">
                    <a href="{{ route('backend.continents.index') }}" class="menu-link">
                        <div data-i18n="Continent">Continent</div>
                    </a>
                </li>

                <li class="menu-item 
                    @if(in_array(Route::currentRouteName(), [
                        'backend.countries.index'
                    ])) active open @endif
                ">
                    <a href="{{ route('backend.countries.index') }}" class="menu-link">
                        <div data-i18n="Pays">Pays</div>
                    </a>
                </li>

                <li class="menu-item 
                    @if(in_array(Route::currentRouteName(), [
                        'backend.index'
                    ])) active open @endif
                ">
                    <a href="{{ route('backend.index') }}" class="menu-link">
                        <div data-i18n="Accueil">Accueil</div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- Gestion des rôles -->
        <li class="menu-item 
            @if(in_array(Route::currentRouteName(), [
                'backend.roles.index', 'backend.roles.show', 'backend.roles.edit', 'backend.roles.users'
            ])) active open @endif
        ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="Gestion des roles">Gestion des roles</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item 
                    @if(in_array(Route::currentRouteName(), [
                        'backend.roles.index', 'backend.roles.show', 'backend.roles.edit', 'backend.roles.users'
                    ])) active open @endif
                ">
                    <a href="{{ route('backend.roles.index') }}" class="menu-link">
                        <div data-i18n="Listes">Listes</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Gestion des comptes utilisateurs -->
        <li class="menu-item 
            @if(in_array(Route::currentRouteName(), [
                'backend.users.index', 'backend.users.create', 'backend.users.show', 'backend.users.edit', 'backend.users.blogs', 'backend.users.comments'
            ])) active open @endif
        ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="Gestion des comptes">Gestion des comptes</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('backend.users.create')) active @endif">
                    <a href="{{ route('backend.users.create') }}" class="menu-link">
                        <div data-i18n="Ajouter">Ajouter</div>
                    </a>
                </li>
                <li class="menu-item 
                    @if(in_array(Route::currentRouteName(), [
                        'backend.users.index', 'backend.users.show', 'backend.users.edit', 'backend.users.blogs', 'backend.users.comments'
                    ])) active open @endif
                ">
                    <a href="{{ route('backend.users.index') }}" class="menu-link">
                        <div data-i18n="Listes">Listes</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Gestion des catégories, balises et blogs -->
        <li class="menu-item 
            @if(in_array(Route::currentRouteName(), [
                'backend.categories.index', 'backend.categories.create', 'backend.categories.show', 'backend.categories.edit', 'backend.categories.blogs',
                'backend.tags.index', 'backend.tags.create', 'backend.tags.show', 'backend.tags.edit', 'backend.tags.blogs',
                'backend.blogs.index', 'backend.blogs.create', 'backend.blogs.show', 'backend.blogs.edit', 'backend.blogs.comments'
            ])) active open @endif"
        >
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="Gestion des actualités">Gestion des actualités</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item @if(in_array(Route::currentRouteName(), ['backend.categories.index', 'backend.categories.create', 'backend.categories.show', 'backend.categories.edit', 'backend.categories.blogs'] )) active @endif">
                    <a href="{{ route('backend.categories.index') }}" class="menu-link">
                        <div data-i18n="Nos catégories">Nos catégories</div>
                    </a>
                </li>
                <li class="menu-item @if(in_array(Route::currentRouteName(), ['backend.tags.index', 'backend.tags.create', 'backend.tags.show', 'backend.tags.edit', 'backend.tags.blogs'] )) active @endif">
                    <a href="{{ route('backend.tags.index') }}" class="menu-link">
                        <div data-i18n="Nos balises">Nos balises</div>
                    </a>
                </li>
                <li class="menu-item @if(in_array(Route::currentRouteName(), ['backend.blogs.index', 'backend.blogs.create', 'backend.blogs.show', 'backend.blogs.edit', 'backend.blogs.comments'] )) active @endif">
                    <a href="{{ route('backend.blogs.index') }}" class="menu-link">
                        <div data-i18n="Nos blogs">Nos blogs</div>
                    </a>
                </li>
            </ul>
        </li>

    <!-- Gestion des produits, et catégories de produits -->
        <li class="menu-item 
            @if(in_array(Route::currentRouteName(), [
                'backend.product_categories.index', 'backend.product_categories.create', 'backend.product_categories.show', 'backend.product_categories.edit', 'backend.product_categories.show',
                'backend.products.index', 'backend.products.create', 'backend.products.show', 'backend.products.edit',
            ])) active open @endif"
        >
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="Gestion des produits">Gestion des produits</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item @if(in_array(Route::currentRouteName(), ['backend.product_categories.index', 'backend.product_categories.create', 'backend.product_categories.show', 'backend.product_categories.edit', 'backend.product_categories.show'] )) active @endif">
                    <a href="{{ route('backend.product_categories.index') }}" class="menu-link">
                        <div data-i18n="Nos catégories">Nos catégories</div>
                    </a>
                </li>
                <li class="menu-item @if(in_array(Route::currentRouteName(), ['backend.products.index', 'backend.products.create', 'backend.products.show', 'backend.products.edit'] )) active @endif">
                    <a href="{{ route('backend.products.index') }}" class="menu-link">
                        <div data-i18n="Nos produits">Nos produits</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item @if(request()->routeIs('backend.subscribes.index') || request()->routeIs('backend.subscribes.create')) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="Gesti... des abonnées">Gesti... des abonnées</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('backend.subscribes.index')) active @endif">
                    <a href="{{ route('backend.subscribes.index') }}" class="menu-link">
                        <div data-i18n="Listes">Listes</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item @if(request()->routeIs('backend.contacts.index')) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="Contacts">Contacts</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('backend.contacts.index')) active @endif">
                    <a href="{{ route('backend.contacts.index') }}" class="menu-link">
                        <div data-i18n="Listes">Listes</div>
                    </a>
                </li>
            </ul>
        </li>
        
        {{--<li class="menu-item @if(request()->routeIs('backend.comments.index')) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="G... des commentaires">G... des commentaires</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('backend.comments.index')) active @endif">
                    <a href="{{ route('backend.comments.index') }}" class="menu-link">
                        <div data-i18n="Listes">Listes</div>
                    </a>
                </li>
            </ul>
        </li>--}}

        {{--<li class="menu-item @if(request()->routeIs('backend.replies.index')) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="Gest... des réponses">Gest... des réponses</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('backend.replies.index')) active @endif">
                    <a href="{{ route('backend.replies.index') }}" class="menu-link">
                        <div data-i18n="Listes">Listes</div>
                    </a>
                </li>
            </ul>
        </li>--}}

        {{--<li class="menu-item @if(request()->routeIs('backend.logs.index')) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-folder-open-fill"></i>
                <div data-i18n="Gestion des logs">Gestion des logs</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item @if(request()->routeIs('backend.logs.index')) active @endif">
                    <a href="{{ route('backend.logs.index') }}" class="menu-link">
                        <div data-i18n="Listes">Listes</div>
                    </a>
                </li>
            </ul>
        </li>--}}

        <!-- Retour à l'interface des utilisateurs -->
        <li class="menu-header small mt-5">
            <a href="{{ route('frontend.index') }}" target="_blank" rel="noopener noreferrer">
                <span class="menu-header-text" data-i18n="Interface principale">
                    Interface principale
                </span>
            </a>
        </li>


    </ul>
</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="ri ri-menu-line icon-base"></i>
        <i class="ri ri-arrow-right-s-line icon-base"></i>
    </a>
</div>
<!-- / Menu -->