<?
Yii::app()->clientScript->registerScript('searchbox', "

	$('.monuf_sw').live('click', function() {
		var o = $('#'+$(this).attr('rel'));
		var s = o.hasClass('hide');
		if (s) {
			o.removeClass('hide');
			$('span',this).html('&#9660;');
		}
		else {
			o.addClass('hide');

			$('span',this).html('&#9658;');
		}
		return false;
	});

    ", CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('sliders', $sliders_js_functions, CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('dynamic_form', "

	$('.topcontainer input[type=checkbox], .topcontainer select').live('change', function(){

        $.ajax({
            type: 'POST',
            url: '/catalog/default/searchbox',
            data: $('#fast-find-form').serialize(),
            beforeSend:  function(){
                $('.topcontainer').fadeTo(100,0.2);
                $('.topcontainer').append('<img src=\"/css/loading.gif\"/>');
            },
            success: function(html) {

                $('.topcontainer').html(html);

                ".$sliders_js_functions."
                $('.topcontainer').fadeTo(100,1);
            },
            error:function(html) {

                $('.topcontainer').html(html);
            }
        });
	});

    ", CClientScript::POS_READY);
?>

		<div class="topmarket podbor">
			<div class="topmarketinner">
				<div class="topcontainer">
                    <?$this->renderFile(Yii::getPathOfAlias('application.modules.catalog.components.views.searchboxinner').'.php', array(                                                                                                               'category_list'=>$category_list,
                                                                                     'brand_list'=>$brand_list,
                                                                                     'priceRange'=>$priceRange,
                                                                                     'selectionParameters'=>$selectionParameters,
                                                                                     'existedParameters'=>$existedParameters,
                                                                                     'allExistedParametersCategory'=>$allExistedParametersCategory,
                                                                                     'attributes'=>$attributes,
                                                                                     'attrRanges'=>$attrRanges,
                                            ));?>
			    </div>
			</div>
		</div>
		<div class="cartshad"></div>
