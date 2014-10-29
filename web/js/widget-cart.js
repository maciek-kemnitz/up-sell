$(function () {

    var uppSellContainer = '<div id="up-sell-container"></div>';
	var allowSubmit = false;

    $.post("http://up-sell.pl/ajax/up-sell/cart", userData, function (ajaxResult) {
        if (ajaxResult['status'] == 'ok') {
            $('body').append(uppSellContainer);

            var screenWidth = $(window).width();
            var modalWidth = screenWidth * 0.8;
            var paddingLeft = 40;

	        var upSellId = ajaxResult['up_sell_id'];
	        var shopDomain = ajaxResult['shopDomain'];
	        var userKey = ajaxResult['user_key'];

            if (modalWidth > 900) {
                modalWidth = 900;
            }

            var modalLeftMargin = (screenWidth - modalWidth) / 2 - paddingLeft;

            $("<style type='text/css'> .modalMargin{ margin-left:" + modalLeftMargin + "px;left: 0px;} </style>").appendTo("head");

	        $('body').delegate('.right-arrow', 'click', function(){
		        listSwitcher($('.multi-item'), this, '.left-arrow');
	        });

	        $('body').delegate('.left-arrow', 'click', function(){
		        listSwitcher($('.multi-item').get().reverse(), this, '.right-arrow');
	        });

	        var form = $('form[method="post"]').first();
//	        change to data-attribute
	        $(form).find('[type="submit"]').attr('id', 'addToCart');

            $('body').delegate('#addToCart','click', function () {

	            if (allowSubmit)
	            {
		            return true;
	            }

                $('#up-sell-modal').addClass('modalMargin');
                $('#up-sell-modal').css('display', 'block');
                $('#up-sell-modal').addClass('in');

	            var statsData = {
		            'shopDomain': shopDomain,
		            'up_sell_id': upSellId,
		            'placement': 'cart',
		            'user_key': userKey
	            };

	            $.post("http://up-sell.pl/ajax/up-sell/stats", statsData, 'json');

                return false;
            });

            $('body').delegate('#variant-select', 'change', function (){
                var newPrice = $(this).find(":selected").data('price');
                var id = '#'+$(this).data('product-id') + "-price";
                $(id).html(newPrice + ' zł');
            });

            $('body').delegate('button.up-sell-add-to-cart', 'click', function () {

                var productId = $(this).data('product-id');
                var select = $(this).parent('div').find('#variant-select');
                if ($(select).length > 0)
                {
                    productId = $(select).find(":selected").val()
                }

                var productData = {
                    'id': productId
                };

	            var statsData = {
		            'shopDomain': shopDomain,
		            'up_sell_id': upSellId,
		            'variant_id': productId,
		            'placement': 'cart',
		            'user_key': userKey
	            };

	            $.post("http://up-sell.pl/ajax/up-sell/stats", statsData, 'json');

                $.post("http://"+ window.location.hostname +"/koszyk/dodaj", productData, function (ajaxResult) {
                    window.location.href = "http://" + window.location.hostname + "/koszyk";
                });

            });

            $('body').delegate('[data-dismiss="modal"]', 'click', function () {

	            allowSubmit = true;
	            var form = $('form[method="post"]').first();
	            $(form).find('[type="submit"]').click();
            });
            $('#up-sell-container').html(ajaxResult['html']);
        }
        else if (ajaxResult['status'] == 'no up-sell') {

//                do nothing
        }

    }, 'json');
});

function listSwitcher(items, currentPointer, oppositePointer)
{
	var counter = 1;
	var doSwitch = false;

	$(items).each(function(){

		if ($(this).is(":visible"))
		{
			$(this).css('display','none');
			doSwitch = true;
		}
		else
		{
			if (doSwitch && counter <= 3)
			{
				$(this).show();
				counter++;
			}
			else if (doSwitch)
			{
				counter++;
			}
		}
	});

	if (counter <= 4)
	{
		$(currentPointer).css('display','none');

	}

	$(oppositePointer).show();
}

//<input type="text" name="updates[VARIANT_ID]" id="updates_VARIANT_ID" value="ILOSC" />