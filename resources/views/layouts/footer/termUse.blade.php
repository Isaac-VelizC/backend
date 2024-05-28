@extends('layouts.app')

@section('content')

<div class="position-relative iq-banner">
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <h1>Condiciones de uso</h1>
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
    <div id="faqAccordion" class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="accordion custom-accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Lorem ipsum dolor sit
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Anim pariatur cliche reprehenderit,</strong> enim eiusmod high life accusamus
                                terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                brunch.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                consectetur adipiscing elit
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Anim pariatur cliche reprehenderit,</strong> enim eiusmod high life accusamus
                                terry richardson ad squid. 3 wolf moon officia aute,
                                <code>non cupidatat skateboard dolor brunch.</code> Food truck quinoa nesciunt laborum
                                eiusmod
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Etiam sit amet justo non
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Anim pariatur cliche reprehenderit,</strong> enim eiusmod high life accusamus
                                terry richardson ad squid. <code> 3 wolf moon officia aute,</code> non cupidatat
                                skateboard dolor brunch.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                velit accumsan laoreet
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Anim pariatur cliche reprehenderit,</strong> enim eiusmod high life accusamus
                                terry richardson ad squid. 3 wolf moon officia
                                aute,<code> non cupidatat skateboard dolor brunch.</code> Food truck quinoa nesciunt
                                laborum eiusmod.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection