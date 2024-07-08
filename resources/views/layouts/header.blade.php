<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="search" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href={{ asset('assets/css/bootstrap.min.css') }}>

    <!-- Customizable CSS -->
    <link rel="stylesheet" href={{ asset('assets/css/main.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/blue.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/owl.carousel.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/owl.transitions.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/animate.min.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/rateit.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/bootstrap-select.min.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/custom.css') }}>

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href={{ asset('assets/css/font-awesome.css') }}>

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800'
        rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <style>
        .fas-icon {
            padding-left: 10px;
        }

        .fas-icon:hover {
            font-size: 20px;
            transition: .25s;
            color: #108bea;
        }

        .list-group-item .active a {
            color: white !important;
        }

        .modal-header .close {
            margin-top: -24px;
        }


        .price-before-discount {
            text-decoration: line-through;
            color: #b5a8a8;
            /* Optional: Change the color to a lighter shade */
        }
    </style>

</head>

<body class="cnt-home">
    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">
        <!-- ============================================== TOP MENU ============================================== -->
        <div class="top-bar animate-dropdown">
            <div class="container">
                <div class="header-top-inner">
                    <div class="cnt-account">
                        <ul class="list-unstyled">
                            <li><a href="{{ Auth::check() ? route('wishlist') : route('login.index') }}"><i
                                        class="icon fa fa-heart"></i>Wishlist</a></li>
                            <li>
                                <a href="{{ route('cart') }}">
                                    <i class="icon fa fa-shopping-cart"></i> My Cart
                                </a>
                            </li>
                            @if (Auth::user())
                                <li><a href="{{ route('order') }}"><i
                                            class="icon fa fa-user"></i>{{ Auth::user()->first_name }}</a></li>
                            @else
                                <li><a href="{{ route('login.index') }}"><i class="icon fa fa-lock"></i>Login</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="cnt-block">
                        <ul class="list-unstyled list-inline">
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- ============================================== TOP MENU : END ============================================== -->
        <div class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                        <div class="logo">
                            @if (!empty($contents['profile']['logo']))
                                <a href="{{ route('index') }}">
                                    <img height="80" src="{{ img_url($contents['profile']['logo']) }}"
                                        alt="logo">
                                </a>
                            @endif
                        </div>
                    </div>
                    <!-- /.logo-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
                        <!-- ============================================================= SEARCH AREA ============================================================= -->
                        <div class="search-area">
                            <form action="{{ route('category', encodeRequestData(907985264855)) }}">
                                <div class="control-group">
                                    <ul class="categories-filter animate-dropdown">
                                        <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown"
                                                href={{ route('category', '') }}>Categories <b class="caret"></b></a>
                                            @if (count($contents['cats']) == 0)
                                                <ul class="dropdown-menu" role="menu"> Not Available</ul>
                                            @else
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="menu-header"><a
                                                            href="{{ route('category', 'All') }}">All</a></li>
                                                    @foreach ($contents['cats'] as $cat)
                                                        @php
                                                            $catHasInventory = false;
                                                            foreach ($cat->ProductSubcategoryUser as $subcategory) {
                                                                $subHasInventory = false;
                                                                foreach ($subcategory->product as $product) {
                                                                    if ($product->inventory_count > 0) {
                                                                        $subHasInventory = true;
                                                                        break;
                                                                    }
                                                                }
                                                                if ($subHasInventory) {
                                                                    $catHasInventory = true;
                                                                }
                                                            }
                                                        @endphp
                                                        @if ($catHasInventory)
                                                            <li class="menu-header">
                                                                <a
                                                                    href="{{ route('category', encodeRequestData($cat->categoryId)) }}">{{ $cat->title }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endif

                                        </li>
                                    </ul>
                                    <input class="search-field" name="search" value="{{ request()->query('search') }}"
                                        placeholder="Search here..." />
                                    <button class="search-button" href="#"></button>
                                </div>
                            </form>
                        </div>
                        <!-- /.search-area -->
                        <!-- ============================================================= SEARCH AREA : END ============================================================= -->
                    </div>
                    <!-- /.top-search-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
                        <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
                        @if (!empty($sessionItems['cartItems']))
                            <div class="dropdown dropdown-cart">
                                <a href="{{ route('cart') }}" class="dropdown-toggle lnk-cart">
                                    <div class="items-cart-inner">
                                        <div class="basket"> <i class="glyphicon glyphicon-shopping-cart"></i> </div>
                                        <div class="basket-item-count"><span class="count"
                                                id="session-count">{{ !empty($sessionItems['qty']) ? $sessionItems['qty'] : '0' }}</span>
                                        </div>
                                        <div class="total-price-basket"> <span class="lbl">cart -</span> <span
                                                class="total-price"> <span class="sign">₹</span><span
                                                    class="sessionTotal value">{{ !empty($sessionItems['subtotal']) ? $sessionItems['subtotal'] : '0' }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                <!-- /.dropdown-menu-->
                            </div>
                        @else
                            <div class="dropdown dropdown-cart">
                                <a href="{{ Auth::check() ? route('cart') : route('login.index') }}"
                                    class="dropdown-toggle lnk-cart" data-toggle="">
                                    <div class="items-cart-inner">
                                        <div class="basket"> <i class="glyphicon glyphicon-shopping-cart"></i> </div>
                                        <div class="basket-item-count"><span class="count"
                                                id="count">{{ !empty($items['qty']) ? $items['qty'] : '0' }}</span>
                                        </div>
                                        <div class="total-price-basket"> <span class="lbl">cart -</span> <span
                                                class="total-price"> <span class="sign">₹</span><span
                                                    class="sub_total value">{{ !empty($items['subtotal']) ? $items['subtotal'] : '0' }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
                    </div>
                    <!-- /.top-cart-row -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container -->

        </div>
        <!-- /.main-header -->

        <!-- ============================================== NAVBAR ============================================== -->
        <div class="header-nav animate-dropdown">
            <div class="container">
                <div class="yamm navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse"
                            class="navbar-toggle collapsed" type="button">
                            <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                                class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    </div>
                    <div class="nav-bg-class">
                        <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                            <div class="nav-outer">
                                <ul class="nav navbar-nav">
                                    <li class="active dropdown yamm-fw"> <a href="{{ route('index') }}">Home</a>
                                    </li>
                                    @foreach ($contents['cats'] as $cat)
                                        @php
                                            $hasInventory = false;
                                            foreach ($cat->ProductSubcategoryUser as $subcategory) {
                                                foreach ($subcategory->product as $product) {
                                                    if ($product->inventory_count > 0) {
                                                        $hasInventory = true;
                                                        break;
                                                    }
                                                }
                                                if ($hasInventory) {
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if ($hasInventory)
                                            <li class="dropdown yamm mega-menu"> <a href="home.html"
                                                    data-hover="dropdown" class="dropdown-toggle"
                                                    data-toggle="dropdown">{{ $cat->title }}</a>
                                                <ul class="dropdown-menu container">
                                                    <li>
                                                        <div class="yamm-content ">
                                                            <div class="row">

                                                                <div class="col-xs-12 col-sm-6 col-md-2 col-menu">
                                                                    @foreach ($cat->ProductSubcategoryUser as $subcategory)
                                                                        @php
                                                                            $subHasInventory = false;
                                                                            foreach (
                                                                                $subcategory->product
                                                                                as $product
                                                                            ) {
                                                                                if ($product->inventory_count > 0) {
                                                                                    $subHasInventory = true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        @if ($subHasInventory)
                                                                            <ul class="links">
                                                                                <li><a
                                                                                        href="{{ route('category', encodeRequestData($subcategory->subCategoryId)) }}">{{ $subcategory->title }}</a>
                                                                                </li>
                                                                            </ul>
                                                                        @endif
                                                                    @endforeach
                                                                </div>

                                                                <div
                                                                    class="col-xs-12 col-sm-6 col-md-4 col-menu banner-image">
                                                                    <img class="img-responsive"
                                                                        src="{{ img_url($cat->image) }}"
                                                                        alt="">
                                                                </div>
                                                                <!-- /.yamm-content -->
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                                <!-- /.navbar-nav -->
                                <div class="clearfix"></div>
                            </div>
                            <!-- /.nav-outer -->
                        </div>
                        <!-- /.navbar-collapse -->

                    </div>
                    <!-- /.nav-bg-class -->
                </div>
                <!-- /.navbar-default -->
            </div>
            <!-- /.container-class -->

        </div>
        <!-- /.header-nav -->
        <!-- ============================================== NAVBAR : END ============================================== -->

    </header>
