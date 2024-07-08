document.addEventListener('DOMContentLoaded', function () {
    var quantityInputs = document.querySelectorAll('.cart-quantity input[type="text"]');
    var plusButtons = document.querySelectorAll('.arrow.plus');
    var minusButtons = document.querySelectorAll('.arrow.minus');

    plusButtons.forEach(function (button, index) {
        button.addEventListener('click', function () {
            var quantityInput = quantityInputs[index];
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });
    });
    minusButtons.forEach(function (button, index) {
        button.addEventListener('click', function () {
            var quantityInput = quantityInputs[index];
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    });
});

function encodeRequestData(data) {
    const key = CryptoJS.enc.Utf8.parse('ACC62A67A3D055E6AF68BD9D3ED9A519');
    const iv = CryptoJS.enc.Utf8.parse('608538a015674f17');
    const encryptedData = CryptoJS.AES.encrypt(data, key, {
        iv: iv,
        padding: CryptoJS.pad.Pkcs7,
        mode: CryptoJS.mode.CBC
    }).toString();
    const encodedData = encodeURIComponent(btoa(encryptedData));
    return encodedData;
}

function addToCart(addToCart) {
    $(addToCart).click(function (e) {
        e.preventDefault();
        var productId = $(this).data('pdtid');
        var quantity = ($('#qty').val() ? $('#qty').val() : 1);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/addToCart',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                pdtId: productId,
                qty: quantity
            },
            success: function (response) {
                if (response.sts == true) {
                    $('#count').text(response.items.qty);
                    $('.sub_total').text(response.items.subtotal);
                    $('.action-button').text("");
                    $('.action-button').empty().append(`<a class="btn btn-primary go_to_cart" href="/cart"><i class="fa fa-shopping-cart inner-right-vs"></i> GO TO CART</a>`);

                    Swal.fire("SUCCESS!", response.msg, "success");
                }
                else if (response.sts == 'session') {
                    $('#session-count').text(response.items.qty);
                    $('.sessionTotal').text(response.items.subtotal);
                    Swal.fire("SUCCESS!", response.msg, "success");
                }
                else {
                    Swal.fire("Error", response.msg, "error");
                }
            },
            error: function (xhr, status, error) {
                Swal.fire("Error", "There was an error adding the item to the cart.", "error");
            }
        });
    });
};

function save_later(id) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/save_later',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            cartId: id,
        },
        success: function (response) {
            if (response.sts == true) {
                $('#count').text(response.items.qty);
                $('.sub_total').text(response.items.subtotal);
                reloadCart('/reload/cart')
                reloadCart('/reload/later')
            }
        }
    });
}

function reloadCart(url) {
    $.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            if (response.sts) {
                $('#count').text(response.items.qty);
                $('.sub_total').text(response.items.subtotal);
                if (url == '/reload/cart') {
                    $('#myCart').html(response.html);
                } else {
                    $('#laterCart').html(response.html);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Error reloading cart:', error);
        }
    });
}

function removeCart(id) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        title: "Are you sure?",
        text: "Want to delete this item!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/remove',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    pdtId: id,
                },
                success: function (response) {
                    if (response.sts == true) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your item has been deleted.",
                            icon: "success"
                        }).then(() => {
                            if (response.sts == true) {
                                $('#count').text(response.items.qty);
                                $('.sub_total').text(response.items.subtotal);
                                $('#summeryList').html(response.html);
                                $('#cartSummery').html(response.cartSummery);
                                reloadCart('/reload/cart')
                                reloadCart('/reload/later')
                            }
                        });
                    }
                    else if (response.sts == 'session') {
                        $('#myCart').empty();
                        $('#myCart').html(response.html);
                        $('#session-count').text(response.items.qty);
                        $('.sessionTotal').text(response.items.subtotal);

                    }
                    else {
                        Swal.fire("Error", response.msg, "error");
                    }
                }
            });
        }
    });
}

function changeQuantity(element, action) {
    const quantInputDiv = element.closest('.quant-input');
    const qtyInput = quantInputDiv.querySelector('.qty-input');
    const idInput = quantInputDiv.querySelector('.id-input');

    let qty = parseInt(qtyInput.value);
    if (action === 'plus') {
        qty++;
    } else if (action === 'minus') {
        if (qty > 1) qty--;
    }
    qtyInput.value = qty;
    const productId = idInput.value;
    updateCart(productId, qty);
}

function updateCart(id, qty) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/updateCart',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: { qty: qty, id: id },
        success: function (response) {
            if (response.sts == true) {
                $('#count').text(response.items.qty);
                $('.sub_total').text(response.items.subtotal);
                $('#summeryList').html(response.html);
                $('#cartSummery').html(response.cartSummery);
                reloadCart('/reload/cart');
                reloadCart('/reload/later');
            }
            else if (response.sts == 'session') {
                $('#myCart').empty();
                $('#myCart').html(response.html);
                $('#session-count').text(response.items.qty);
                $('.sessionTotal').text(response.items.subtotal);

            }
            else {
                Swal.fire("Error", response.msg, "error");
            }
        }
    });
}

function wishlist(wishlist) {
    $(wishlist).click(function (e) {
        e.preventDefault();
        var productId = $(this).data('pdtid');
        console.log(productId);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/wishlist',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                pdtId: productId,
            },
            success: function (response) {
                if (response.sts == true) {
                    Swal.fire("SUCCESS!", response.msg, "success");
                } else {
                    if (response.login == false) {
                        window.location.href = "/auth";
                    } else {
                        Swal.fire("Error", response.msg, "error");
                    }
                }
            },
            error: function (xhr, status, error) {
                Swal.fire("Error", "There was an error adding the item to the cart.", "error");
            }
        });
    });
};

function removewishlist(removewishlist) {
    $(removewishlist).click(function (e) {
        e.preventDefault();
        var productId = $(this).data('pdtid');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: "Are you sure?",
            text: "Want to delete this item!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/wishlist_remove',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        pdtId: productId,
                    },
                    success: function (response) {
                        if (response.sts == true) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your item has been deleted.",
                                icon: "success"
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire("Error", response.msg, "error");
                        }
                    }
                });
            }
        });
    });
}

function category(category) {
    $(category).click(function (e) {
        e.preventDefault();
        var productId = $(this).data('pdtid');
        console.log(productId);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/cat-list',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                catId: productId,
            },
            success: function (response) {
                if (response.sts == true) {
                    var productSlider = $('#smartphone .product-slider .owl-carousel');
                    productSlider.empty();
                    productSlider.append(response.header);
                } else {
                    var productSlider = $('#smartphone .product-slider .owl-carousel');
                    productSlider.empty();
                    productSlider.append(
                        `<div class="item item-carousel text-center pb-3" style="padding-bottom: 20px; text-align: center;">
                       Products Not Available
                    </div>`
                    );
                }
            },
            error: function (xhr, status, error) {
                Swal.fire("Error", "There was an error adding the item to the cart.", "error");
            }
        });
    });
};

function filter() {
    $('#positionSelect').change(function () {
        var selectedValue = $(this).val();
        console.log(selectedValue); // Get the selected value from the select element
        csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                filter: selectedValue // Pass the selected value to the server
            },
            success: function (response) {
                // Handle success response
            }
        });
    });
}

$('.state').append('<option value="">Select State</option>');
function getstate() {
    let country_id = $(".country").val();
    console.log(country_id);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/user/get-state',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            country_id: country_id,
        },
        success: function (response) {
            let res = response.countries;
            $('.state').empty();
            $.each(res, function (index, subcategory) {
                $('.state').append('<option value="' + subcategory.id + '">' + subcategory.title + '</option>');
            });
        },
        error: function (xhr, status, error) {
            Swal.fire("Error", "There was an error.", "error");
        }
    });
};


function add_remove(add_remove) {
    $(add_remove).click(function (e) {
        e.preventDefault();
        var Add_id = $(this).data('add_id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: "Are you sure?",
            text: "Want to delete this item!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/user/add-remove',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        add_id: Add_id,
                    },
                    success: function (response) {
                        if (response.sts == true) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your item has been deleted.",
                                icon: "success"
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire("Error", response.msg, "error");
                        }
                    }
                });
            }
        });
    });
}

function img_url(img) {
    return "http://192.168.1.32:9000/media/" + img;
}

$(window).ready(function () {
    addToCart('.addToCart');
    wishlist('.wishlist');
    removewishlist('.wishlist_remove');
    category('.cat-list');
    add_remove('.add_remove');

    //Events for checkout Page
    $(".edit").hide();
    $(".change").hide();
    $(".address-form").hide();
    $(".checkout-deliver").hide();
    $(".pay-now").hide();

    // Billing and Shipping Checkbox handling
    function handleCheckboxChange(checkboxClass, editClass, deliverClass) {
        $(document).on('change', checkboxClass, function (e) {
            e.preventDefault();
            $(checkboxClass).not(this).prop("checked", false);
            $(editClass).hide();
            $(deliverClass).hide();
            var isChecked = $(this).prop("checked");
            if (isChecked) {
                $(this).closest(".row").find(editClass).show();
                $(this).closest(".panel-body").find(deliverClass).show();
            } else {
                $(this).closest(".row").find(editClass).hide();
                $(this).closest(".panel-body").find(deliverClass).hide();
            }
        });
    }

    handleCheckboxChange('.billingCheckbox', '.edit', '.checkout-deliver');
    handleCheckboxChange('.shippingCheckbox', '.edit', '.checkout-deliver');

    // COD handling
    $(document).on('change', '.cod', function (e) {
        e.preventDefault();
        $(".cod").not(this).prop("checked", false);
        $(".pay-now").hide();
        var isChecked = $(this).prop("checked");
        if (isChecked) {
            $(".pay-now").show();
        } else {
            $(".pay-now").hide();
        }
    });

    // Add address handling
    $(document).on('click', '.add', function (e) {
        e.preventDefault();
        $(this).hide();
        $(".list").hide();
        $("#id").val('');
        $(".checkout-deliver").hide();
        $(".hr").hide();
        $(".cancle").show();
        $(this).closest(".panel-collapse").find(".address-form").show();
        $(this).closest(".panel-collapse").find(".address-form").trigger("reset");
        $(".update-btn").text('Submit');
    });

    // Edit address handling
    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        let addId = $(this).closest('.list').find('.billingCheckbox,.shippingCheckbox').val();
        $(".list").hide();
        $(".add").hide();
        $(".cancle").show();
        $(".checkout-deliver").hide();
        $(".hr").hide();
        $(this).closest(".panel-collapse").find(".address-form").show();
        $(".update-btn").text('Update');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/user/add-edit',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                addId: addId
            },
            success: function (response) {
                $(".address").val(response.data.address);
                $(".mobile").val(response.data.mobile);
                $(".label-2").val(response.data.label);
                $(".city").val(response.data.city);
                $(".pin_code").val(response.data.pin_code);
                $("#id").val(response.data.id);
                $(".country").val(response.data.country_id).change();
                setTimeout(function () {
                    $(".state").val(response.data.state_id);
                }, 600);
            }
        });
    });

    // Cancel handling
    $(document).on('click', '.cancle', function (e) {
        e.preventDefault();
        $('#Billing_address').find('.invalid-feedback').html('');
        $('#Billing_address').find('.form-control').removeClass('is-invalid');
        $(".list").show();
        $(".checkout-deliver").show();
        $("hr").show();
        $(".edit").hide();
        $(".add").show();
        $(".address-form").hide();
        $(this).closest(".panel-body").find(".checkout-deliver").hide();
        $(".checkBox").not(this).prop("checked", false);
    });

    // Checkout address handling
    function checkout_Address(updateAddress, url) {
        $(document).on('submit', updateAddress, function (e) {
            e.preventDefault();
            $(updateAddress).find('.invalid-feedback').html('');
            $(updateAddress).find('.form-control').removeClass('is-invalid');
            let FormData = $(this).serialize();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: url,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: FormData,
                success: function (response) {
                    if (response.sts) {
                        Swal.fire("SUCCESS!", response.msg, "success").then(() => {
                            $('#checkoutAdd').html(response.html);
                            $(".list").show();
                            $(".add").show();
                            $(".edit").hide();
                            $(".address-form").hide();
                            $("hr").show();
                            $(".checkout-deliver").hide();
                            $(updateAddress)[0].reset();
                            reloadAddress();
                        });
                    } else {
                        displayErrors(response.errors);
                    }
                }
            });
        });

        function displayErrors(errors) {
            $.each(errors, function (key, error) {
                let field = $(updateAddress).find(`[name="${key}"]`);
                field.addClass('is-invalid');
                field.next('.invalid-feedback').html(error[0]);
            });
        }
    }

    checkout_Address('#Billing_address', '/user/address-update');
    checkout_Address('#shipping_address', '/user/address-update');

    // Checkout steps handling
    $(document).on('click', '.checkout-continue', function (e) {
        e.preventDefault();
        $(this).closest('.panel').find('.change').show();
    });

    $(document).on('click', '.change', function (e) {
        e.preventDefault();
        $(this).closest('.panel').find('.change').hide();
        $(this).closest('.billingCheckbox').prop("checked", false);
        $(this).closest('.shippingCheckbox').prop("checked", false);
        $(this).closest('.panel-default').nextAll().find('.change').hide();
    });

    // Place order handling
    $(document).on('click', '.pay-now', function (e) {
        e.preventDefault();
        $('.change').hide();
        $(this).html('Order Placed');
        $(this).prop('disabled', true);
        let shippingId = $('.checkout-step-05').find('.shippingCheckbox:checked').val();
        let billingId = $('.checkout-step-02').find('.billingCheckbox:checked').val();
        console.log(shippingId);
        console.log(billingId);
        let pay_mode = $('.cod:checked').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/user/order',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                shippingId: shippingId,
                billingId: billingId,
                payMode: pay_mode,
            },
            success: function (response) {
                if (response.sts) {
                    window.location.href = 'user/thank-you';
                } else {
                    $('.change').show();
                    $('.pay-now').html('Order Now');
                    $('.pay-now').prop('disabled', false);

                    Swal.close();

                    if (response.errors && response.errors.length > 0) {
                        let errorMessage = '<ul>';
                        response.errors.forEach(function (error) {
                            errorMessage += '<li>' + error + '</li>';
                        });
                        errorMessage += '</ul>';

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: errorMessage,
                        });
                    } else {
                        Swal.fire('Error!', 'Unknown error occurred.', 'error');
                    }
                }
            }
        });
    });
});


$(document).on('click', '.applyCoupon', function (e) {
    e.preventDefault();
    let coupon = $('#coupon').val();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/user/applyCoupon',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            coupon: coupon
        },
        success: function (response) {
            if(response.sts){
                $('#coupon').prop('disabled', true);
                $('.applyCoupon').prop('disabled', true);
                $('.applyCoupon').html('Applied');
                $('.sus-coupon').html(response.msg); 
            }else{
                $('.inv-coupon').html(response.msg);   
            }
            ;
        }
    });
});

function reloadAddress() {
    $.ajax({
        type: "GET",
        url: "/user/address-status",
        success: function (response) {
            $('#shippingAddress').html(response.html);
        },
        error: function (xhr, status, error) {
            console.error("Error occurred:", error);
        }
    });
}
$.ajax({
    type: "GET",
    url: "/user/address-status",
    success: function (response) {
        if (response.count == 0) {
            $(".add").hide();
            $(".cancle").hide();
            $(".address-form").show();
        }
    },
    error: function (xhr, status, error) {
        console.error("Error occurred:", error);
    }
});
function funCancel(orderId, status, reason, details, inventoryId, qty) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/user/order/update-status',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            orderId: orderId,
            status: status,
            reason: reason,
            details: details,
            inventoryId: inventoryId,
            quantity: qty
        },
        success: function (response) {
            if (response.sts) {
                Swal.fire("SUCCESS!", response.msg, "success").then(function () {
                    $('#actionModal').modal('hide');
                    window.location.reload();
                });
            } else {
                // Check if there are validation errors
                if (response.errors && response.errors.length > 0) {
                    let errorMessage = '<ul>';
                    response.errors.forEach(error => {
                        errorMessage += `<li>${error}</li>`;
                    });
                    errorMessage += '</ul>';
                    Swal.fire("ERROR!", errorMessage, "error");
                } else {
                    Swal.fire("ERROR!", response.msg, "error");
                }
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const actionButtons = document.querySelectorAll('.order-action');
    const orderIdInput = document.getElementById('orderId');
    const actionTypeInput = document.getElementById('actionType');
    const inventoryIdInput = document.getElementById('inventoryId');
    const quantityInput = document.getElementById('qty');

    actionButtons.forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.getAttribute('data-id');
            const actionType = this.getAttribute('data-action');
            const inventoryId = this.getAttribute('data-invId');
            const qty = this.getAttribute('data-qty');

            orderIdInput.value = orderId;
            actionTypeInput.value = actionType;
            inventoryIdInput.value = inventoryId;
            quantityInput.value = qty;

            // Set the modal title based on the action
            document.getElementById('actionModalLabel').textContent = actionType === 'Cancelled' ? 'Cancel Order' : 'Return Order';
        });
    });

    document.getElementById('submitAction').addEventListener('click', function () {
        const form = document.getElementById('actionForm');
        const orderId = orderIdInput.value;
        const actionType = actionTypeInput.value;
        const reason = form.reason.value;
        const details = form.details.value;
        const inventoryId = inventoryIdInput.value;
        const qty = quantityInput.value;

        funCancel(orderId, actionType, reason, details, inventoryId, qty);

    });
});