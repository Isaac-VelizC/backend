@extends('layouts.app')

@section('content')
<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>Política de privacidad</h1>
                            <p>Fecha de la última actualización: 20 de mayo de 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-header-img">
            <img src="{{ asset('img/fondo1.jpg') }}" alt="header"
                class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        </div>
    </div>
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Información general</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>El Instituto Técnico IGLA se compromete a proteger la privacidad de los usuarios de su aplicación web. 
                            Esta Política de Privacidad describe cómo recopilamos, utilizamos y protegemos la información personal que nos proporcionas al utilizar nuestra aplicación.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Información recopilada</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Recopilamos la siguiente información personal de los usuarios:
                            <ul>
                                <li>Nombre completo</li>
                                <li>CI/NIT</li>
                                <li>Dirección de correo electrónico</li>
                                <li>Número de teléfono</li>
                                <li>Información académica (por ejemplo, grado, curso, calificaciones)</li>
                                <li>Información de contacto de emergencia</li>
                            </ul>
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Uso de la información</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Utilizamos la información personal recopilada para los siguientes fines:
                            <ol>
                                <li>Proporcionar acceso a la aplicación y sus funcionalidades</li>
                                <li>Comunicarnos con los usuarios sobre asuntos académicos y administrativos</li>
                                <li>Enviar notificaciones y actualizaciones importantes</li>
                                <li>Mejorar y personalizar la experiencia del usuario en la aplicación</li>
                                <li>Cumplir con los requisitos legales y normativos</li>
                            </ol>
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Compartir información</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>No compartimos la información personal de los usuarios con terceros, excepto en los siguientes casos:
                            <ul>
                                <li>Cuando sea necesario para cumplir con los requisitos legales o judiciales</li>
                                <li>Para proteger los derechos, la propiedad o la seguridad del Instituto Técnico IGLA, sus usuarios o el público en general</li>
                                <li>Con proveedores de servicios que trabajan en nuestro nombre y tienen un acuerdo de confidencialidad</li>
                            </ul>
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Seguridad de la información</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Implementamos medidas de seguridad físicas, electrónicas y administrativas para proteger la información personal de los usuarios contra el
                             acceso no autorizado, la divulgación, la alteración o la destrucción. Sin embargo, no podemos garantizar la seguridad absoluta de la 
                             información transmitida a través de Internet.
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Derechos de los usuarios</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Los usuarios tienen derecho a acceder, corregir, actualizar o eliminar su información personal almacenada en nuestros sistemas. 
                            Para ejercer estos derechos, los usuarios deben comunicarse con el Departamento de Tecnología de la Información del Instituto Técnico IGLA.
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Cambios en la Política de Privacidad</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Nos reservamos el derecho de modificar esta Política de Privacidad en cualquier momento. Cualquier cambio se publicará en esta página, y la fecha de la última actualización se indicará al final de la política.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Contacto</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Si tienes alguna pregunta o inquietud sobre esta Política de Privacidad o sobre cómo manejamos la información personal, 
                            no dudes en comunicarte con nosotros a través del siguiente correo electrónico: aisakvelizcd@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection
