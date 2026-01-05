<!-- views/partials/sidebar.blade.php -->
<aside>

<ul class="menu">
    <li class="menu-item">
        <button class="menu-btn">👥 Sistema Roles</button>
        <ul class="submenu">
            <li><a href="{{ route('roles.index') }}">• Roles</a></li>
        </ul>
    </li>

    <li class="menu-item">
        <button class="menu-btn">🎵 Sistema Musical</button>
        <ul class="submenu">
            <li><a href="{{ route('musicos.index') }}">• Musicos</a></li>
            <li><a href="{{ route('notasMusicales.index') }}">• Nota Musical</a></li>
        </ul>
    </li>

</ul>

</aside>
