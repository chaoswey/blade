<header>
    <h3>header</h3>
    <ol>
        @for($i = 1; $i <= 5; $i++)
            <li>menu{{ $i }}</li>
        @endfor
    </ol>
</header>