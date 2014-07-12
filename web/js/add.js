$(function(){
    $('#price-range-label').click(function() {

        if ($("input[name='price-range']").is(':checked'))
        {
            $("input[name='price_from']").removeAttr('disabled');
            $("input[name='price_to']").removeAttr('disabled');

        }
        else
        {
            $("input[name='price_from']").attr('disabled', 'disabled');
            $("input[name='price_to']").attr('disabled', 'disabled');
        }
    });

    $('#select-discount').change(function(){
        var selected = $('#select-discount option:selected').val();
        var html = '';
        switch(selected)
        {
        case 'percent':
        html = $('<div class="hide"><span class="add-on">%</span><input name="discount-amount" type="text" style="height: 30px;"></div>');
        $('.discount-container').html(html);
        html.toggle();
        break;

        case 'amount':
        html = $('<div class="hide"><span class="add-on">$</span><input name="discount-amount" type="text" style="height: 30px;"</div>');
        $('.discount-container').html(html);
        html.toggle();
        break;

        case 'none':
        $('.discount-container').html('');

        }
    });

    $('#related-ac').keyup(function(){

        if ($(this).val())
        {
        $('#related-ac-result-container').removeClass('hide');
        $(this).css('border-color','#1c1f27');
        var query = $(this).val();

        var userData = {
        'query': query
        };

    $.post('/ajax/autocomplete', userData, function (ajaxResult) {
        if(ajaxResult.status == 'ok'){
        $('#related-ac-result-container').find('.autocompleter-list').html(ajaxResult.html);
        }
    }
    , 'json');
    }
    else
                {
                    $(this).css('border-color','');
                    $('#related-ac-result-container').addClass('hide');
                    }
    });

    $('#up-sell-ac').keyup(function(){

        if ($(this).val())
        {
        $('#up-sell-ac-result-container').removeClass('hide');
        $(this).css('border-color','#1c1f27');
        var query = $(this).val();

        var userData = {
        'query': query
        };

	    $.post('/ajax/autocomplete', userData, function (ajaxResult) {
	        if(ajaxResult.status == 'ok'){
	            $('#up-sell-ac-result-container').find('.autocompleter-list').html(ajaxResult.html);
	        }
	    }
	    , 'json');
	    }
	    else
        {
	        $(this).css('border-color','');
			$('#up-sell-ac-result-container').addClass('hide');
        }
    });

    $('#related-ac-result-container').on('click', 'li.item', function(){
        var imgSrc = $(this).data('thumbnail');
        var name = $(this).data('name');
        var variantData = $(this).data('variants');

        if ($(this).data('variants'))
        {
            variantData = variantData.split(";");
        }

        var productId = $(this).data('id');
        var html = '<li class="with-handle with-meta preloaded" data-id="8">' +
            '<a class="delete" data-icon="!"></a>' +
            '<span class="thumb-100 fade in" style="margin-top: 51px;">' +
            '<img src="'+imgSrc+'">' +
                '</span>' +
            '<section class="meta">' +
                '<span class="text">'+ $.trim(name)+'</span>' +
                '</section>';

            if ($(this).data('variants'))
            {
                html += '<select id="variant_selectedPCR" name="variant_selectedPCR-'+productId+'[]" class="prevent-render variant-selector" style="visibility: visible;">' +
                    '<option value="null">Wszystkie</option>';
                for (i = 0; i < variantData.length; i +=2)
                {
                    html += '<option value="'+ variantData[i] +'">'+ variantData[i+1] +'</option>';
                }

                html +=  '</select>';
            }

        html += '<input type="hidden" name="selected-product-trigger[]" value="'+productId+'">' +
            '</li>';


        $('#related-ac').css('border-color','');
        $('#related-ac-result-container').addClass('hide');
        $('#related').find('ul.photos.products').append(html);
        $('#related-ac').val('');
    });

    $('#up-sell-ac-result-container').on('click', 'li.item', function(){
        var imgSrc = $(this).data('thumbnail');
        var name = $(this).data('name');
        var variantData = $(this).data('variants');

        if ($(this).data('variants'))
        {
            variantData = variantData.split(";");
        }

        var productId = $(this).data('id');
        var html = '<li class="with-handle with-meta preloaded" data-id="8">' +
            '<a class="delete" data-icon="!"></a>' +
            '<span class="thumb-100 fade in" style="margin-top: 51px;">' +
            '<img src="'+imgSrc+'">' +
                '</span>' +
            '<section class="meta">' +
                '<span class="text">'+ $.trim(name)+'</span>' +
                '</section>';

            if ($(this).data('variants'))
                {
                    html += '<select id="variant_selected" name="variant_selected-'+productId+'" class="prevent-render variant-selector" style="visibility: visible;">' +
                        '<option value="null">Wszystkie</option>';
                    for (i = 0; i < variantData.length; i +=2)
                    {
                    html += '<option value="'+ variantData[i] +'">'+ variantData[i+1] +'</option>';
                    }

            html +=  '</select>';
        }

        html += '<input type="hidden" name="up-sell-products[]" value="'+productId+'">' +
            '</li>';
        $('#up-sell-ac').css('border-color','');
        $('#up-sell-ac-result-container').addClass('hide');
        $('#up-sell').find('ul.photos.products').append(html);
        $('#up-sell-ac').val('');
    });

});
