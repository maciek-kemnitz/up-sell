$(function () {

    var uppSellContainer = '<div id="up-sell-container"></div>';

    $.post("http://up-sell.mkemnitz.linuxpl.info/ajax/up-sell/product", userData, function (ajaxResult) {
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

            $('body').on('click', 'input[name="addToCard"]', function () {
                $('#up-sell-modal').addClass('modalMargin');
                $('#up-sell-modal').css('display', 'block');
                $('#up-sell-modal').addClass('in');

                var form = $(this).parent('form');
                var input = $(this).parent('form').find('input[name="id"]');
                var productId = $(this).parent('form').find('input[name="id"]').attr('type');
                console.log(form);
                console.log(input);
                console.log(productId);
                var productData = {
                  'id': productId
                };
                $.post("http://"+ window.location.hostname +"/koszyk/dodaj", productData);

                return false;
            });

            $('body').on('click', '[data-dismiss="modal"]', function () {
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
