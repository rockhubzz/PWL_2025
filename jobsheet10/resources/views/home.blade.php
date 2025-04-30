<html>
    <head>
        <title>Home POS</title>
    </head>
    <body>
        <h1>Welcome to POS</h1>
        <nav>
            <ul>
                <li><a href="{{ url('/category/food-beverage') }}">Food & Beverage</a></li>
                <li><a href="{{ url('/category/beauty-health') }}">Beauty & Health</a></li>
                <li><a href="{{ url('/category/home-care') }}">Home Care</a></li>
                <li><a href="{{ url('/category/baby-kid') }}">Baby & Kid</a></li>
                <li><a href="{{ url('/user/1/name/JohnDoe') }}">User Profile</a></li>
                <li><a href="{{ url('/sales') }}">Sales Info</a></li>
            </ul>
        </nav>
    </body>
</html>