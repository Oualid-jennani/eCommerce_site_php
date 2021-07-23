
function changeListP(){$.post('CodeValid.php',{ShowPanier:true}, function(data){document.getElementById("infoPanier").innerHTML = data;countP();cart_Price();});}

function countP(){$.post('CodeValid.php',{countP:true}, function(data){document.getElementById("countPanier").innerHTML = data});}

function delpanier(key){$.post('CodeValid.php',{deletkey:key},function(data){
	changeListP();

	var RemoveLi = document.getElementById(""+key+"");

	if(RemoveLi){
        RemoveLi.remove();
	}
});}

function editqtP(key,event){$.post('CodeValid.php',{editKey:key,valueqt:event.target.value},function(data){});}

function cart_Price(){

	var i = 0,Total = 0;
	var tabTotal = document.getElementsByClassName("ST");
	for(i = 0 ; i < tabTotal.length ; i++){
		Total += parseFloat(tabTotal[i].textContent);

		var ST2 = document.getElementsByClassName("ST-2")[i];
		if(ST2){
			ST2.innerHTML = parseFloat(tabTotal[i].textContent).toFixed(2) + " DH";
		}
		
	}
	document.getElementById("cart_price").innerHTML = Total.toFixed(2);
	var order_total = document.getElementById("order_total");
    if(order_total){
        order_total.innerHTML = Total.toFixed(2);
	}
	
}
changeListP();



function countheart(){
	$.post('CodeValid.php',{countHeart:"true"},function(data){
		document.getElementById("wishlist_count").innerHTML = data;
	});
}

countheart();



$(document).ready(function()
{
	"use strict";




	$('.cart_icon').click(function(){  
        $('.infoPanier').slideToggle(150);
    });







	initCustomDropdown();

	function initCustomDropdown()
	{
		if($('.custom_dropdown_placeholder').length && $('.custom_list').length)
		{
			var placeholder = $('.custom_dropdown_placeholder')
			var cat_hidden = $('.cat_hidden');
			var list = $('.custom_list');
		}
	
		placeholder.on('click', function (ev)
		{
			if(list.hasClass('active'))
			{
				list.removeClass('active');
			}
			else
			{
				list.addClass('active');
			}
	
			$(document).one('click', function closeForm(e)
			{
				if($(e.target).hasClass('clc'))
				{
					$(document).one('click', closeForm);
				}
				else
				{
					list.removeClass('active');
				}
			});
	
		});
	
		$('.custom_list a').on('click', function (ev)
		{
			ev.preventDefault();
			var index = $(this).parent().index();
	
			placeholder.text( $(this).text() ).css('opacity', '1');
			cat_hidden.val($(this).text());
			if(list.hasClass('active'))
			{
				list.removeClass('active');
			}
			else
			{
				list.addClass('active');
			}
		});
	
	
		$('select').on('change', function (e)
		{
			placeholder.text(this.value);
	
			$(this).animate({width: placeholder.width() + 'px' });
		});
	}
	




    
});



