<footer id="footer" class="footer color-bg">
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Customer Service</h4>
                    </div>
                    <!-- /.module-heading -->
                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a href="{{ Auth::check() ? route('profile') : route('login.index') }}"
                                    title="Contact us">My Account</a></li>
                            <li><a href="{{ Auth::check() ? route('order') : route('login.index') }}"
                                    title="About us">Order History</a></li>
                            <li><a href="{{ route('faq') }}" title="faq">FAQ</a></li>
                            <li><a href="#" title="Popular Searches">Specials</a></li>
                            <li class="last"><a href="#" title="Where is my order?">Help Center</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Corporation</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a title="Your Account" href="#">About us</a></li>
                            <li><a title="Information" href="#">Customer Service</a></li>
                            <li><a title="Addresses" href="#">Company</a></li>
                            <li><a title="Addresses" href="#">Investor Relations</a></li>
                            <li class="last"><a title="Orders History" href="#">Advanced Search</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Why Choose Us</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a href="#" title="About us">Shopping Guide</a></li>
                            <li><a href="#" title="Blog">Blog</a></li>
                            <li><a href="#" title="Company">Company</a></li>
                            <li><a href="#" title="Investor Relations">Investor Relations</a></li>
                            <li class=" last"><a href="contact-us.html" title="Suppliers">Contact Us</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Contact Us</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class="toggle-footer" style="">
                            <li class="media">
                                <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                            class="fa fa-map-marker fa-stack-1x fa-inverse"></i> </span> </div>
                                <div class="media-body">
                                    @if (!empty($contents['address']))
                                        <p>{{ $contents['address']['address'] }}</p>
                                    @endif
                                </div>
                            </li>
                            <li class="media">
                                <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                            class="fa fa-mobile fa-stack-1x fa-inverse"></i> </span> </div>
                                <div class="media-body">
                                    @if (!empty($contents['info']))
                                        <a href="tel:+91{{ $contents['info']['mobile'] }}">+(91)
                                            {{ $contents['info']['mobile'] }}</a>
                                    @endif
                                </div>
                            </li>
                            <li class="media">
                                <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                            class="fa fa-envelope fa-stack-1x fa-inverse"></i> </span>
                                </div>
                                @if (!empty($contents['info']))
                                    <div class="media-body"> <span><a
                                                href="mailto:{{ $contents['info']['email'] }}">{{ $contents['info']['email'] }}</a></span>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-bar">
        <div class="container">
            {{-- <div class="col-xs-12 col-sm-2 no-padding social">
                <ul class="link">
                    <li class="fb pull-left">
                        <a target="_blank" rel="nofollow" href="#" title="Facebook"></a>
                    </li>
                    <li class="tw pull-left">
                        <a target="_blank" rel="nofollow" href="#" title="Twitter"></a>
                    </li>
                    <li class="googleplus pull-left">
                        <a target="_blank" rel="nofollow" href="#" title="GooglePlus"></a>
                    </li>
                    <li class="rss pull-left">
                        <a target="_blank" rel="nofollow" href="#" title="RSS"></a>
                    </li>
                    <li class="pintrest pull-left">
                        <a target="_blank" rel="nofollow" href="#" title="PInterest"></a>
                    </li>
                    <li class="linkedin pull-left">
                        <a target="_blank" rel="nofollow" href="#" title="Linkedin"></a>
                    </li>
                    <li class="youtube pull-left">
                        <a target="_blank" rel="nofollow" href="#" title="Youtube"></a>
                    </li>
                </ul>
            </div> --}}
            <div class="no-padding">
                <div class="clearfix payment-methods">
                    <span style="color: white">©2023 All Rights Reserved, Powered by</span><a
                       target="_blank" href="https://csgtech.in/"> CSG Technosol Private Limited.</a>
                </div>
                <!-- /.payment-methods -->
            </div>
            {{-- <div class="col-xs-12 col-sm-2 no-padding">
                <div class="clearfix payment-methods">
                    <ul>
                        <li><img src={{ asset('assets/images/payments/1.png') }} alt=""></li>
                        <li><img src={{ asset('assets/images/payments/2.png') }} alt=""></li>
                        <li><img src={{ asset('assets/images/payments/3.png') }} alt=""></li>
                        <li><img src={{ asset('assets/images/payments/4.png') }} alt=""></li>
                        <li><img src={{ asset('assets/images/payments/5.png') }} alt=""></li>
                    </ul>
                </div>
                <!-- /.payment-methods -->
            </div> --}}
        </div>
    </div>
</footer>
<!-- ============================================================= FOOTER :-->
    
<!-- Cancel/Return Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Order Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actionForm">
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input type="text" class="form-control" id="reason" name="reason" required>
                    </div>
                    <div class="form-group">
                        <label for="details">Reason Details</label>
                        <textarea class="form-control" id="details" name="details" rows="3" required></textarea>
                    </div>
                    <input type="hidden" id="orderId" name="orderId">
                    <input type="hidden" id="actionType" name="actionType">
                    <input type="hidden" id="inventoryId" name="inventoryId">
                    <input type="hidden" id="qty" name="qty">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitAction">Submit</button>
            </div>
        </div>
    </div>
</div>



<!--    END============================================================= -->

<!-- For demo purposes – can be removed on production -->

<!-- For demo purposes – can be removed on production : End -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<!-- JavaScripts placed at the end of the document so the pages load faster -->
<script src={{ asset('assets/js/jquery-1.11.1.min.js') }}></script>
<script src={{ asset('assets/js/bootstrap.min.js') }}></script>
<script src={{ asset('assets/js/bootstrap-hover-dropdown.min.js') }}></script>
<script src={{ asset('assets/js/owl.carousel.min.js') }}></script>
<script src={{ asset('assets/js/echo.min.js') }}></script>
<script src={{ asset('assets/js/jquery.easing-1.3.min.js') }}></script>
<script src={{ asset('assets/js/jquery.rateit.min.js') }}></script>
<script type="text/javascript" src={{ asset('assets/js/lightbox.min.js') }}></script>
<script src={{ asset('assets/js/bootstrap-select.min.js') }}></script>
<script src={{ asset('assets/js/wow.min.js') }}></script>
<script src={{ asset('assets/js/scripts.js') }}></script>
<script src={{ asset('assets/js/custom.js') }}></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11 "></script>

<script src={{ asset('assets/js/bootstrap-slider.min.js') }}></script>

<script>
    function toggleEdit() {
        var fields = document.querySelectorAll(
            '#email, #current_password, #password, #con_password,#first_name,#last_name');
        var editBtn = document.querySelector('.outer-left-xs');

        fields.forEach(function(field) {
            field.readOnly = !field.readOnly;
        });

        if (editBtn.textContent === 'Edit') {
            editBtn.textContent = 'Cancel';
            editBtn.classList.remove('btn-primary');
            editBtn.classList.add('btn-danger');
            document.querySelector('button[type="submit"]').style.display = 'inline-block';
        } else {
            editBtn.textContent = 'Edit';
            editBtn.classList.remove('btn-danger');
            editBtn.classList.add('btn-primary');
            document.querySelector('button[type="submit"]').style.display = 'none';
        }
    }
</script>
</body>

<!-- Mirrored from www.themesground.com/flipmart-demo/HTML/home.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 26 Feb 2019 09:18:01 GMT -->

</html>
