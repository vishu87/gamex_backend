$(function() {
	$.extend($.tablesorter.themes.bootstrap, {
		table      : 'table table-bordered',
		header     : 'bootstrap-header', // give the header a gradient background
		footerRow  : '',
		footerCells: '',
		icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
		sortNone   : 'fa fa-sort',
		sortAsc    : 'fa fa-chevron-up',
		sortDesc   : 'fa fa-chevron-down',
		active     : '', // applied when column is sorted
		hover      : '', // use custom css here - bootstrap class may not override it
		filterRow  : '', // filter row class
		even       : '', // odd row zebra striping
		odd        : ''  // even row zebra striping
	});
	
	$(".tablesorter").tablesorter({
		theme : "bootstrap",
		widthFixed: false,
		headerTemplate : '{content} {icon}', 
		widgets : [ "uitheme", "filter", "zebra" ],
		widgetOptions : {
			zebra : ["even", "odd"],
			filter_reset : ".reset"
		},
		headers: {
			0 : {
	        	sorter: false,
	        	filter: false
	      	},
	    }
	})
});

$(document).ready(function(){
	$(".datepicker").datepicker({'format':'dd-mm-yyyy'});

	$(".p_val").keyup(function(){
		var val = parseInt($(this).val());
		var currency = parseInt($("input[name=currency_id]:checked").val());
		if(currency == 1) $(".p_val_naira").val(val);
		else if(currency == 2) $(".p_val_naira").val(val*200);
		else if(currency == 3) $(".p_val_naira").val(val*295);
		else if(currency == 4) $(".p_val_naira").val(val*216);
		else if(currency == 5) $(".p_val_naira").val(val*52);
		else $(".p_val_naira").val(0);
	});

	$("input[name=currency_id]").change(function(){
		var val = parseInt($(".p_val").val());
		var currency = parseInt($(this).val());
		if(currency == 1) $(".p_val_naira").val(val);
		else if(currency == 2) $(".p_val_naira").val(val*200);
		else if(currency == 3) $(".p_val_naira").val(val*295);
		else if(currency == 4) $(".p_val_naira").val(val*216);
		else if(currency == 5) $(".p_val_naira").val(val*52);
		else $(".p_val_naira").val(0);
	});

});

function del_prop(id) {
    bootbox.confirm("Are you sure to delete this proposal?", function(result) {
      if(result) {
        $.post(base_url+"/admin/proposal/delete/"+id, {id:id}, function(data) {
            if(data == 'success') {
              $("#tr_"+id).hide('slow', function(){
              	$("#tr_"+id).remove();
              });
            } else {
              alert("You can not delete this item");
            }
         });
      }
      else {
      
      }
    });
}
// select payee for fund transfer///

$("#to").change(function(e){
	e.preventDefault();
	var datatosend = $("#to").serialize();
	$.ajax({
	    type: "POST",
	    url : base_url+'/admin/getpayee',
	    data : datatosend,
	    success : function(data){
	    	
	    	data = JSON.parse(data);
	    	var str = '';
	    	for (var i = 0; i <= data.length - 1; i++) {
	    		str = str + '<option value="'+data[i].id+'">'+data[i].value+'</option>';
	    	}
	    	$("#payee").html(str);
	    }
	});
});



 // handle the login on enter 
$('.login input').keypress(function (e) {
    if (e.which == 13) {
        $('.login-form').submit();
    }
});