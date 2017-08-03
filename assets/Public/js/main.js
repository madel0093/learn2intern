$(document).ready(function(){
	if( $(".calendar-datetime").length ) {
		$(".calendar-datetime").datetimepicker({
			format: 'MMM DD, YYYY  hh:mm A',
		});
	}

	if( $("select.select2").length ) {
		$("select.select2").select2();
	}
});


$(document).ready(function(){
	$(".checkpoint-meta").hide();
	$(".checkpoint-meta.open").show();
	$("select#type").change(function(){
		var type = $(this).val();
		if( type ) {
			$(".checkpoint-meta").fadeOut('fast');
			$(".checkpoint-meta#"+type).fadeIn('slow');
		}
	})
});


$(document).ready(function(){
	var index = $("ul.list").children().length;
	$("#add-new-option").click(function(e){
		e.preventDefault();
		$("ul.list").append(
			'<li>'+
			'  <div class="form-group">'+
			'    <div class="col-sm-1">'+
			'      <div class="checkbox">'+
			'        <label><input type="radio" name="correct" required="" value="'+ index +'"></label>'+
			'      </div>'+
			'    </div>'+
			'    <div class="col-sm-9">'+
			'      <input type="text" class="form-control" required="" name="options[]" placeholder="Enter New Choice Here">'+
			'    </div>'+
			'    <div class="col-sm-2">'+
			'      <a href="#" class="btn btn-danger del">DELETE</a>'+
			'    </div>'+
			'  </div>'+
			'</li>'
			);
		index++;
	});

	$(document).on('click', '#mcq ul li a.del', function(e){
		e.preventDefault();
		$(this).parent().parent().parent().animate({ opacity: 0 }, 200, function() {
			$(this).remove();
			resetIndex();
		});
	});

	function resetIndex() {
		$('#mcq ul li').each(function(i) {
			$(this).find('input[type=radio]').val(i);
		});
	}

});