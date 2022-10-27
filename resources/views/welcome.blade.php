<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="inicio/css/main.css">
    <title>SIE CURSOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>

    <!-- HEADER -->

    <header class="container-fluid bg-primary d-flex justify-content-center">
        <p class="text-light mb-0 p-2 fs-6">Contactanos +591 78797979</p>
    </header>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg bg-light p-3" id="menu">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <span class="text-primary fs-5 fw-bold"> SIE CURSOS </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#equipo">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#seccion-contacto">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Campus virtual</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CAROUSEL -->

    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="inicio/img/slide1.jpg" class="d-block w-100" alt="slide1">
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="inicio/img/slide2.jpg" class="d-block w-100" alt="slide2">
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="inicio/img/slide3.jpg" class="d-block w-100" alt="slide3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- INTRO -->

    <section class="w-50 mx-auto text-center pt-3" id="intro">
        <h1 class="p-3 fs-2 border-top border-3">Una institucion única la cual brinda cursos
            de capacitaciones <span class="text-primary">desde cero.</span></h1>
        <p class="p-3 fs-4"><span class="text-primary">SIE CURSOS</span> es la institucion
            donde aprenderas reparacion de celulares, computadoras, herramientras tecnologicas como
            Photoshop, Illustrator y mucho mas con nuestros cursos 100% prácticos.</p>
    </section>

    <!-- SERVICIOS -->

    <section class="container-fluid">
        <div class="row w-75 mx-auto" class="servicio-fila">
            <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
                <img src="inicio/img/imagen3.jpg" alt="Titulo" width="180" height="160">
                <div>
                    <h3 class="fs-5 mt-4 px-4 pb-1">Reparación de celulares</h3>
                    <p class="px-4">Mantenimiento y reparación de celulares.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
                <img src="inicio/img/imagen1.jpg" alt="Titulo" width="180" height="160">
                <div>
                    <h3 class="fs-5 mt-4 px-4 pb-1">Reparación de impresoras</h3>
                    <p class="px-4">Mantenimiento y reparación de impresoras EPSON Y CANON.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
                <img src="inicio/img/photoshop.png" alt="Titulo" width="180" height="160">
                <div>
                    <h3 class="fs-5 mt-4 px-4 pb-1">Photoshop desde 0</h3>
                    <p class="px-4">Curso práctico para aprender photoshop desde lo mas básico.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
                <img src="inicio/img/premiere.png" alt="Titulo" width="180" height="160">
                <div>
                    <h3 class="fs-5 mt-4 px-4 pb-1">Premiere pro</h3>
                    <p class="px-4">Curso práctio para aprender esta potente herramienta de diseño.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- NOSOTROS -->

    <section>
        <div class="container w-50 m-auto text-center" id="equipo">
            <h1 class="mb-5 fs-2">Nosotros</h1>
            <p class="fs-4 ">Contamos con personal capacitado y con experiencia en enseñanza a
                estudiantes de todas las edades.</p>
        </div>

        <div class="mt-5 text-center">
            <img id="img-equipo" src="inicio/img/equipo.jpg" alt="equipo">
        </div>

        <div id="local" class="border-top border-2">
            <div class="mapa"> </div>
            <div>
                <div class="wrapper">
                    {{-- <h2>Ubicado en la avenida America</h2> --}}
                    <h2 class="text-primary mb-4" id="typewriter"></h2>
                    <p class="fs-5 text-body">Estamos ubicados en la avenida America y Gabriel Reno Moreno #949.
                        <br> De 08:00 a 19:00 de lunes a sabado.
                    </p>
                    {{-- <section class="d-flex justify-content-start" id="numeros-local">
                        <div>
                            <p class="text-primary fs-5">248</p>
                            <p>Dias de sol</p>
                        </div>
                        <div>
                            <p class="text-primary fs-5">100%</p>
                            <p>Aprobado</p>
                        </div>
                        <div>
                            <p class="text-primary fs-5">24 °C</p>
                            <p>Temperatura</p>
                        </div>
                    </section> --}}
                </div>
            </div>
        </div>
    </section>

    <!-- Formulario -->

    <section id="seccion-contacto" class="border-bottom border-secondary border-2">
        <div id="bg-contacto">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#1b2a4e" fill-opacity="1"
                    d="M0,32L120,42.7C240,53,480,75,720,74.7C960,75,1200,53,1320,42.7L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z">
                </path>
            </svg>
        </div>
        <!-- Form -->
        <div class="container" id="contenedor-formulario">
            <div class="text-center mb-4" id="titulo-formulario">
                <div><img src="inicio/img/support.png" alt="" class="img-fluid" width="200"
                        height="200"></div>
                <h2>Contactos</h2>
                <p class="fs-5">Estamos aqui para hacer realidad tus proyectos</p>
            </div>
            <form action="">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="nombre@ejemplo.com"
                        required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Telefono</label>
                    <input type="email" class="form-control" id="tel" placeholder="" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Escribe tu mensaje"></textarea>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary w-100 fs-5" type="button">Enviar mensaje</button>
                </div>
            </form>

        </div>
    </section>

    <!-- FOOTER -->

    <footer class="w-100 d-flex align-items-center justify-content-center flex-wrap">
        <p class="fs-5 px-3 pt-3">SIE CURSOS. &copy; Todos los derechos reservados 2022</p>
        <div id="iconos">
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-whatsapp"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

    <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>

    <script src="inicio/js/main.js"></script>

</body>

</html>
