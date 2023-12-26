<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 shadow rounded mb-3">
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ route('home') }}">Tiki</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link fw-medium" aria-current="page" href="{{ route('home') }}">Home<a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fw-medium" aria-current="page"
                                        href="{{ route('trips.create') }}">Add Trip<a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link fw-medium" aria-current="page" href="">Buy Tickets<a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link fw-medium" aria-current="page"
                                        href="{{ route('locations.index') }}">Locations<a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
