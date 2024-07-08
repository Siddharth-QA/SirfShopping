@extends('layouts.app')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class='active'>Profile</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->

    <div class="body-content outer-top-xs" id="top-banner-and-menu">
        <div class="container bg-white p-3">
            <div class="row">
                {{-- {% include "my-account/sidebar.html" %} --}}
                <div class="col-xs-12 col-sm-12 col-lg-3 sidebar pr-lg-0 bg-white">
                    <div class="side-menu animate-dropdown border h-100">
                        <nav class="yamm megamenu-horizontal">
                            <ul class="list-group">
                                <li class="list-group-item {% if 'orders/' in request.path %} active {% endif %}"><a href="{% url 'orders.index' %}">Orders</a>
                                </li>
                                <li class="list-group-item {% if 'my-account' in request.path %} active {% endif %}"><a href="{% url 'my-account' %}" class="active">Profile</a>
                                </li>
                                <li class="list-group-item {% if 'my-address' in request.path %} active {% endif %}"><a href="{% url 'my-address' %}">My Address</a>
                                </li>
                                <li class="list-group-item {% if 'change-password' in request.path %} active {% endif %}">
                                    <a href="{% url 'change-password' %}">Password Change</a>
                                </li>
                                <li class="list-group-item"><a href="{% url 'logout'%}">Logout</a></li>
                            </ul>
                            <!-- /.nav -->
                        </nav>
                        <!-- /.megamenu-horizontal -->
                    </div>
                    <!-- /.side-menu -->
                </div>
            </div>
        </div>
        <div id="brands-carousel" class="logo-slider wow fadeInUp">
            <div class="logo-slider-inner">
                <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                    <div class="item m-t-15">

                    </div>
                    <!--/.item-->
                </div>
                <!-- /.owl-carousel #logo-slider -->
            </div>
            <!-- /.logo-slider-inner -->
        </div>
    </div>
@endsection
