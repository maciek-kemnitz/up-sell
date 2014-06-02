$(function () {

    var uppSellContainer = '<div id="up-sell-container"></div>';

    $.post("http://up-sell.pl/ajax/up-sell/product", userData, function (ajaxResult) {
        if (ajaxResult['status'] == 'ok') {
            $('body').append(uppSellContainer);

            var screenWidth = $(window).width();
            var modalWidth = screenWidth * 0.8;
            var paddingLeft = 40;

            if (modalWidth > 900) {
                modalWidth = 900;
            }

            var modalLeftMargin = (screenWidth - modalWidth) / 2 - paddingLeft;
            $("<style type='text/css'> .modalMargin{ margin-left:" + modalLeftMargin + "px;}</style>").appendTo("head");

            $('body').delegate('input[name="addToCard"]','click', function () {
                console.log('addtocard click');
                $('#up-sell-modal').addClass('modalMargin');
                $('#up-sell-modal').css('display', 'block');
                $('#up-sell-modal').addClass('in');

                var productId = $(this).parents('form').find('input[name="id"]').val();
                var productData = {
                  'id': productId
                };
                $.post("http://"+ window.location.hostname +"/koszyk/dodaj", productData);

                return false;
            });

            $('body').delegate('button.up-sell-add-to-cart', 'click', function () {
                console.log('du[a');
                var productId = $(this).data('product-id');

                if ($('#variant-select').length > 0)
                {
                    productId = $('#variant-select').find(":selected").val()
                }

                var productData = {
                    'id': productId
                };


                $.post("http://"+ window.location.hostname +"/koszyk/dodaj", productData, function (ajaxResult) {
                    window.location.href = "http://" + window.location.hostname + "/koszyk";
                });

            });

            $('body').delegate('[data-dismiss="modal"]', 'click', function () {
                console.log('dismis-modal click');
                $('#up-sell-modal').removeClass('in');
                $('#up-sell-modal').css('display', 'none');
                if ($(this).hasClass("to-basket")) {
                    window.location.href = "http://" + window.location.hostname + "/koszyk";
                }
            });
            $('#up-sell-container').html(ajaxResult['html']);
        }
        else if (ajaxResult['status'] == 'no up-sell') {

//                do nothing
        }

    }, 'json');
});
