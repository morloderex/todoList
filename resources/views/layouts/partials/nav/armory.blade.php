<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        Armory <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        @if(\Illuminate\Support\Facades\Auth::check())
            <li>
                <a data-pjax href="{{ route('armory.account.index') }}">Accounts</a>
            </li>

            <li>
                <a data-pjax href="{{ route('armory.character.index') }}">Characters</a>
            </li>
        @endif
            <li>
                <a data-pjax href="{{ route('armory.item.index') }}">Items</a>
            </li>
    </ul>
</li>
