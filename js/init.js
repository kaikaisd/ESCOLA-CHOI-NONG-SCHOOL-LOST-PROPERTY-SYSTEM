(function($){
    $(function(){
    $('.button-collapse').sideNav();
    $('.modal').modal();
    $('.datepicker').pickadate({
	selectMonths: true,
	selectYears:30,
	today:'Today',
	clear:'Clear',
	closeOnSelect: true,
	format:'yyyy-mm-dd'
	})
		$('.timepicker').pickatime({
	default : 'now',
  fromnow: 0,  
	twelvehour:false,
	donetext:'OK',
	cleartext:'Clear',
	canceltext:'Cancel',
	format:'HH:mm:ss'
	},'setTime', new Date());
	
	
	$('select').material_select();
	$('ul.tabs').tabs();
	 $('#cstable').pageMe({
    pagerSelector:'#myPager',
    activeColor: 'green',
    prevText:'上10個',
    nextText:'下10個',
    showPrevNext:true,
    hidePageNumbers:false,
    perPage:10
  });
	  $('#admintable').pageMe({
    pagerSelector:'#myPager',
    activeColor: 'green',
    prevText:'上10個',
    nextText:'下10個',
    showPrevNext:true,
    hidePageNumbers:false,
    perPage:10
  });
  });
})(jQuery);


function removedisable(){
	var item = $("#item").val();
	var time = $("#time").val();
	var date = $("#date").val();
	var info = $("#textarea1").val();
	if ((((item&&time)&&date)&&info)!==""){
	$('#submit').removeClass('disabled');
	}else{
		$('#submit').addClass('disabled');
	};	
}

function valueChanged()
{
    if($('#onoff').is(":checked")){
        $("#file").show(300);
    	$("#userfile").addClass("required");
    }else{
        $("#file").hide(300);
    	$("#userfile").removeClass("required");
    }
}


function disableupload(){
	$("#file").hide();
}

$(document).on('click', 'th', function() {
  var table = $(this).parents('table').eq(0);
  var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
  this.asc = !this.asc;
  if (!this.asc) {
    rows = rows.reverse();
  }
  table.children('tbody').empty().html(rows);
});

function comparer(index) {
  return function(a, b) {
    var valA = getCellValue(a, index),
      valB = getCellValue(b, index);
    return $.isNumeric(valA) && $.isNumeric(valB) ?
      valA - valB : valA.localeCompare(valB);
  };
}
function getCellValue(row, index) {
  return $(row).children('td').eq(index).text();
}


$(document).ready(function(){
  $("#searchinput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#admintableitem tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#searchinput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#normaltable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

function hidesearch()
{
    var x = document.getElementById("searchbar");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
function detectifzero(){
  if ($("#status").val()=='0'){
    $("#date1").removeAttr("required");
    $("#time1").removeAttr("required");
    $("#time1").val("");
    $("#date1").val("");
  }else{
    $("#date1").Attr("required");
    $("#time1").Attr("required");
  }
}
$(document).ready(function(){ 
    $(window).scroll(function(){ 
        if ($(this).scrollTop() > 100) { 
            $('#scroll').fadeIn(); 
        } else { 
            $('#scroll').fadeOut(); 
        } 
    }); 
    $('#scroll').click(function(){ 
        $("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    }); 
});
