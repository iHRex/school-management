jQuery(document).ready(function($) {
	
	$("body").on("click", "#varify_key", function(event){
	$(".cmgt_ajax-img").show();
	$(".page-inner").css("opacity","0.5");
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	var res_json;
	var licence_key = $('#licence_key').val();
	var enter_email = $('#enter_email').val();
	var curr_data = {
		action: 'cmgt_verify_pkey',
		licence_key : licence_key,
		enter_email : enter_email,
		dataType: 'json'
	};	
									
	$.post(smgt.ajax, curr_data, function(response) { 						
		console.log(response);
							res_json = JSON.parse(response);
							
							$('#message').html(res_json.message);
							$("#message").css("display","block");
							$(".cmgt_ajax-img").hide();
							$(".page-inner").css("opacity","1");

							if(res_json.cmgt_verify == '0')
							{
								window.location.href = res_json.location_url;
							}
							return true; 					
	 					});	
	
  });
	$(".section_id_exam").change(function()
	{
		return false;
		$('#subject_list').html('');			
		var class_id = $("#class_list").val();	
		//alert(selection);
        var section_id = $("#class_section").val();
		/* alert(selection_id);
		return false; */
			var curr_data = {
				action: 'smgt_load_subject_class_id_and_section_id',
				class_id:class_id,
                section_id:section_id,				
				dataType: 'json'
			};
		 $.post(smgt.ajax, curr_data, function(response) {
			 
			    $('#subject_list').append(response);				
			});
	});
	
	
	$(".section_id_exam").change(function()
	{
		$('#subject_list').html('');			
		var class_id = $("#class_list").val();	
		//alert(selection);
        var section_id = $("#class_section").val();
		/* alert(selection_id);
		return false; */
			var curr_data = {
				action: 'smgt_load_subject_class_id_and_section_id',
				class_id:class_id,
                section_id:section_id,				
				dataType: 'json'
			};
		 $.post(smgt.ajax, curr_data, function(response) {
			 
			    $('#subject_list').append(response);				
			});
	});
	
	
  $("body").on("click", "#pdf", function(){
 var student_id = $("#student_id").val();
  var curr_data = {
					action: 'smgt_result_pdf',
					student_id: student_id,			
					dataType: 'json'
					};
					$.post(smgt.ajax, curr_data, function(response) 
					{
						return true;
					});	
		});

  $("body").on("click", ".view-notice", function(event){	  
	  var notice_id = $(this).attr('id');
	  //alert(notice_id);
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	 
	   var curr_data = {
	 					action: 'smgt_view_notice',
	 					notice_id: notice_id,			
	 					dataType: 'json'
	 					};
	 					//alert('hello');
	 					$.post(smgt.ajax, curr_data, function(response) {
	 						
	 						//alert('hello');
	 						$('.popup-bg').show().css({'height' : docHeight});
							$('.notice_content').html(response);	
	 						return true;
	 						
	 					
	 					
	 					});	
	 		});

	
	//alert('hello');
  /* $('.popup').click(function() {
     var NWin = window.open($(this).prop('href'), '', 'scrollbars=1,height=400,width=400');
     if (window.focus)
     {
       NWin.focus();
     }
     return false;
    });*/
	
	//POP-UP 
	
	
	//notice_for_ajax
	
	$("body").on("change", ".notice_for_ajax", function(event){	
		var selection = $(this).val();
		if(selection == 'parent' || selection=='supportstaff')
		{
			$('#smgt_select_class').hide();
			$('#smgt_select_section').hide();
		}
		else if(selection=='teacher' || selection == 'all')
		{
			$('#smgt_select_section').hide();
		}
		else
		{
			$('#smgt_select_class').show();
			$('#smgt_select_section').show();
		}	
		
	});
	$(".notice_for_ajax").trigger("change");
	
	 
	$("body").on("click", ".show-popup", function(event){	
		var student_id = $(this).attr('idtest') ;		
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling
			
		var curr_data = {
			action: 'smgt_result',
			student_id: student_id,			
			dataType: 'json'
		};
		
		$.post(smgt.ajax, curr_data, function(response) {
			//alert(response);
			/* console.log(response);
			return false;  */
			$('.popup-bg').show().css({'height' : docHeight});
			$('.result').html(response);	
		});	
	});
	$("body").on("click", ".active-user", function(event){	
		var student_id = $(this).attr('idtest') ;			
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling
		
		
		var curr_data = {
			action: 'smgt_active_student',
			student_id: student_id,			
			dataType: 'json'
		};
				
		$.post(smgt.ajax, curr_data, function(response) {
			$('.popup-bg').show().css({'height' : docHeight});
			$('.result').html(response);	
						
		});	
	});	
		
		$("body").on("click", ".close-btn", function(){		
			$( ".result" ).empty();
			$( ".view-parent" ).empty();
			$('.popup-bg').hide(); // hide the overlay
		});
		
	$("#class_list").change(function(){
		$('#subject_list').html('');			
		var selection = $("#class_list").val();	
	/* 	alert(selection);
		return false;   */
		var optionval = $(this);
			var curr_data = {
				action: 'smgt_load_subject',
				class_list: $("#class_list").val(),			
				dataType: 'json'
			};
			
			$.post(smgt.ajax, curr_data, function(response) {
				/* alert(response);
				return false;  */
				$('#subject_list').append(response);
			});
	});
	//--------------- TEACHER BY CLASS ----------//
	$(".class_by_teacher").change(function(){
		var class_list=$(".class_by_teacher").val();
		/* alert(class_list);
		return false; */
		$('#subject_teacher').html('');			
		var optionval = $(this);
			var curr_data = {
				action: 'smgt_load_teacher_by_class',
				class_list:class_list,
				dataType: 'json'
			};
			
			$.post(smgt.ajax, curr_data, function(response) {
				$(".teacher_list option[value='remove']").remove();
				$('.teacher_list').append(response);
				jQuery('.teacher_list').multiselect('rebuild');			
				return false;
			});
	});
	//------------------- GET EXAM LIST BY CLASS ID --------------//
	$(".class_id_exam").change(function(){
		$('.exam_list').html('');			
		var class_id = $("#class_list").val();		
		var optionval = $(this);
			var curr_data = {
				action: 'smgt_load_exam',
				class_id:class_id,			
				dataType: 'json'
			};
			
			$.post(smgt.ajax, curr_data, function(response) {
				$('.exam_list').append(response);
			});
	});
	//------------------- GET EXAM LIST BY SECTION ID --------------//
	$(".section_id_exam").change(function(){
		$('.exam_list').html('');			
		var class_id = $(".class_id_exam").val();	
		var section_id = $("#class_section").val();	
		 
			var curr_data = {
				action: 'smgt_load_exam_by_section',
				class_id:class_id,			
				section_id:section_id,			
				dataType: 'json'
			};
			
			$.post(smgt.ajax, curr_data, function(response) {
				$('.exam_list').append(response);
			});
	});
	/* Notification Module*/
$("#notification_class_list_id,#notification_class_section_id").change(function(){		
	var class_list = $("#notification_class_list_id").val();	
	var class_section = $("#notification_class_section_id").val();
	var clicked_id = $(this).attr('id');
	
	var curr_data = {
		action: 'smgt_notification_user_list',			
		class_list: class_list,					
		class_section: class_section,					
		dataType: 'json'
	};
	
$.post(smgt.ajax, curr_data, function(response) {

 var json_obj = $.parseJSON(response);//parse JSON			 
	
	if(clicked_id!='notification_class_section_id')
	{
		$('#notification_class_section_id').html('');
		$('#notification_class_section_id').append(json_obj['section']);
	}	
	$('.notification_user_display_block').html('');
	$('.notification_user_display_block').append(json_obj['users']);
	// $('#notification_selected_users').multiselect({ 
	// nonSelectedText :'Select Users',
	// includeSelectAllOption: true
// });
return false;
		
	});
});
	
	/*-----------------LOAD SECTION WISE STUDENT------------------------------------*/
	$("body").on("change", "#class_section", function(event){	 
		var section_id = $("#class_section").val();
		var class_list = $("#class_list").val();
		
		var curr_data = {
			action: 'smgt_load_section_student',
			section_id : section_id,			
			class_list : class_list,			
			dataType: 'json'
		};	
		$.post(smgt.ajax, curr_data, function(response) 
		{
			$('#demo').append(response);
		});
		
		
	});
	
	  // START select student class wise
	  $("body").on("change", "#class_list", function(event){	
	 
		$('#student_list').html('');		
		var selection = $(this).val();				
		var optionval = $(this);
		var curr_data = {
			action: 'smgt_load_user',
			class_list: selection,
			dataType:'json'
		};
			
		$.post(smgt.ajax, curr_data, function(response) {			
			$('#student_list').append(response);	
		});					
					
	});
	// START select student class wise
	  $("#class_section").change(function(){
		$('#student_list').html('');
		//alert(curr_data);
		 var selection = $(this).val();
		// alert(selection);
		var optionval = $(this);
			var curr_data = {
				action: 'smgt_load_section_user',
				section_id: selection,			
				dataType: 'json'
			};
					
			$.post(smgt.ajax, curr_data, function(response) 
			{
				$('#student_list').append(response);	
			});
						
					
	});
	// START select student class wise
	 $("body").on("change", "#class_list", function(){	
		//alert('hello');
		$('#class_section').html('');
		$('#class_section').append('<option value="remove">Loading..</option>');
		//alert(curr_data);
		 var selection = $("#class_list").val();
		 var optionval = $(this);
		var curr_data = {
			action: 'smgt_load_class_section',
			class_id: selection,			
			dataType: 'json'
		};
		$.post(smgt.ajax, curr_data, function(response) 
		{
			$("#class_section option[value='remove']").remove();
			$('#class_section').append(response);	
		});					
					
	});
	 // START select book category wise
	
	$("#bookcat_list").change(function(){				
		$('#book_list1').html('');
		var selection = $("#bookcat_list").val();		
		var optionval = $(this);
			var curr_data = {
				action: 'smgt_load_books',
				bookcat_id: $("#bookcat_list").val(),			
				dataType: 'json'
			};
					
			$.post(smgt.ajax, curr_data, function(response) {
				// $('#book_list').multiselect();
				$('#book_list1').append(response);	
				jQuery('#book_list1').multiselect('rebuild');
			});					
	});
	
	
	 $("body").on("change", ".load_fees", function(){	
	
		$('#fees_data').html('');
		//alert(curr_data);
		 var selection = $("#class_list").val();
		
		var optionval = $(this);
			var curr_data = {
					action: 'smgt_load_class_fee_type',
					class_list: selection,			
					dataType: 'json'
					};
					
					
					$.post(smgt.ajax, curr_data, function(response) {
						//alert(response);
						
					
					$('#fees_data').append(response);	
					});
						
					
	});
	/*---------------FEE TYPE LOAD SECTION WISE--------------------------*/
	/*$("body").on("change", "#class_section", function(event){	
	
		$('#fees_data').html('');	
		//alert(curr_data);
		 var selection = $("#class_section").val();
		
		var optionval = $(this);
			var curr_data = {
					action: 'smgt_load_section_fee_type',
					section_id: selection,			
					dataType: 'json'
					};
					//alert(curr_data);
					$.post(smgt.ajax, curr_data, function(response) {
						
						$('#fees_data').append(response);
					});
	});*/
	$("#fees_data").change(function()
	{
		var selection = $("#fees_data").val();
		var optionval = $(this);
			var curr_data = {
					action: 'smgt_load_fee_type_amount',
					fees_id: $("#fees_data").val(),			
					dataType: 'json'
					};
					$.post(smgt.ajax, curr_data, function(response)
					{
						$("#fees_amount").val(response);
					}); 
	});
	  //END USER LOAD FUNCTION
// select all checkboxes by select one .............	  
	  $('#selectall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
	  
	  
	   
		// hide popup when user clicks on close button
		$('.close-btn').click(function(){
		//var id1 = $(this).data('idtest') ;
		$( ".view-parent" ).empty();
		$('.popup-bg').hide(); // hide the overlay
		});
		
		// hides the popup if user clicks anywhere outside the container
	// END POPUP
	
	
	
	 // START POPUP FOR EDIT OPTION OF PERIOD
    	/*$('.period_box').click(function(event){
			var period_id = $(this).attr('id') ;
			
			
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling
		
		
		
					
					
						
						$('.popup-bg').show().css({'height' : docHeight});
						
						$('.edit_perent').html(period_id);	
						
					
					
				
		}); */
		
		// hide popup when user clicks on close button
		$('.close-btn').click(function(){
		//var id1 = $(this).data('idtest') ;
		$( ".edit_perent" ).empty();
		$('.popup-bg').hide(); // hide the overlay
		});
		
		//SMS Message
		$("input[name=select_serveice]:radio").change(function(){
			
			 var curr_data = {
						action: 'smgt_sms_service_setting',
						select_serveice: $(this).val(),			
						dataType: 'json'
						};					
						
						$.post(smgt.ajax, curr_data, function(response) {	
							
							
						$('#sms_setting_block').html(response);
						});
		});
		
		 $("#chk_sms_sent").change(function(){
			
			 if($(this).is(":checked"))
			{
				 //alert("chekked");
				 $('#hmsg_message_sent').addClass('hms_message_block');
				 
			}
			 else
			{
				 $('#hmsg_message_sent').addClass('hmsg_message_none');
				 $('#hmsg_message_sent').removeClass('hms_message_block');
			}
		 });
		  $("body").on("click", ".close-btn-cat", function(){		
				
				$( ".category_list" ).empty();
				
				$('.popup-bg').hide(); // hide the overlay
				}); 
		 $("body").on("click", ".show-invoice-popup", function(event){
				

			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			  var docHeight = $(document).height(); //grab the height of the page
			  var scrollTop = $(window).scrollTop();
			  var idtest  = $(this).attr('idtest');
			  var invoice_type  = $(this).attr('invoice_type');
			  
				//alert(idtest);
				//return false;
			   var curr_data = {
			 					action: 'smgt_student_invoice_view',
			 					idtest: idtest,
			 					invoice_type: invoice_type,
			 					dataType: 'json'
			 					};	 	
									//alert('hello');					
			 					$.post(smgt.ajax, curr_data, function(response) { 	
			 						//alert(response);	 
			 					$('.popup-bg').show().css({'height' : docHeight});							
								$('.invoice_data').html(response);	
								return true; 					
			 					});	
			
		  });
		 $("body").on("click", ".show-payment-popup", function(event){
				

			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			  var docHeight = $(document).height(); //grab the height of the page
			  var scrollTop = $(window).scrollTop();
			  var idtest  = $(this).attr('idtest');
			  var view_type  = $(this).attr('view_type');
			  var due_amount  = $(this).attr('due_amount');
			  var student_id  = $(this).attr('student_id');
			 
			   var curr_data = {
			 					action: 'smgt_student_add_payment',
			 					idtest: idtest,
			 					view_type: view_type,
			 					due_amount: due_amount,
			 					student_id: student_id,
			 					dataType: 'json'
			 					};	 	
									//alert('hello');					
			 					$.post(smgt.ajax, curr_data, function(response) { 	
			 						//alert(response);	 
			 					$('.popup-bg').show().css({'height' : docHeight});							
								$('.invoice_data').html(response);	
								return true; 					
			 					});	
			
		  });
		  $("body").on("click", ".show-view-payment-popup", function(event){
				

			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			  var docHeight = $(document).height(); //grab the height of the page
			  var scrollTop = $(window).scrollTop();
			  var idtest  = $(this).attr('idtest');
			  var view_type  = $(this).attr('view_type');			  
				//alert(idtest);
			   var curr_data = {
			 					action: 'smgt_student_view_paymenthistory',
			 					idtest: idtest,
			 					view_type1: view_type,
			 					dataType: 'json'
			 					};	 	
													
			 					$.post(smgt.ajax, curr_data, function(response) { 	
			 						//alert(response);	 
									
			 					$('.popup-bg').show().css({'height' : docHeight});							
								$('.invoice_data').html(response);	
								return true; 					
			 					});	
			
		  });

jQuery("body").on("click", "#addremove", function(event){	
	
	
	//event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	var docHeight 	= 	$(document).height(); //grab the height of the page
	var scrollTop 	= 	$(window).scrollTop();
	var class_id	=	0;
	var model  	= 	$(this).attr('model') ;
	 
	if(model=='class_sec')
	{
		class_id 	 = 	jQuery(this).attr('class_id') ;
	}
	
	var curr_data 	= {
		action: 'smgt_add_remove_feetype',
		model : model,
		class_id : class_id,
		dataType: 'json'
	};	 				
	jQuery.post(smgt.ajax, curr_data, function(response) { 	
		 
		jQuery('.popup-bg').show().css({'height' : docHeight});
		jQuery('.modal-content').html(response);	
		return true; 					
	});	
});

  
jQuery("body").on("click", "#btn-add-cat", function(){	
	
	 var fee_type  = $('#txtfee_type').val() ;
		var model  = $(this).attr('model');	
		var class_id=0;
		if(model=='class_sec')
		{
			 class_id  = $(this).attr('class_id') ;
		}
		
		var valid = jQuery('#fee_form').validationEngine('validate');
		
		if (valid == true) 
		{
		/* if(fee_type != "")
		{ */
			var curr_data = {
				action: 'smgt_add_fee_type',
				model : model,
				class_id : class_id,
				fee_type: fee_type,			
				dataType: 'json'
			};
					
			$.post(smgt.ajax, curr_data, function(response) {
				var json_obj = $.parseJSON(response);//parse JSON						
				$('.table').append(json_obj[0]);
				$('#txtfee_type').val("");	
				if(model == 'rack_type')
				{
					$("#rack_category_data").append(json_obj[1]);
				}
				else								
					$("#category_data").append(json_obj[1]);				
					return false;					
			});	
		
		}
		/* else
		{
			alert("Please enter Category Name.");
		} */
		 
	});
	 $("body").on("click", ".btn-delete-cat", function(){		
		var cat_id  = $(this).attr('id') ;	
		 var model  = $(this).attr('model') ;
		
		if(confirm(language_translate2.delete_record_alert))
		{
			var curr_data = {
					action: 'smgt_remove_feetype',
					model : model,
					cat_id:cat_id,			
					dataType: 'json'
					};
					
					$.post(smgt.ajax, curr_data, function(response) {						
						$('#cat-'+cat_id).hide();
						
						if(model == 'rack_type')
						{
							$("#rack_category_data").find('option[value='+cat_id+']').remove();
						}
						else
							$("#category_data").find('option[value='+cat_id+']').remove();
						return true;				
					});			
		}
	});
$("body").on("click", ".btn-edit-cat", function(){		
		var cat_id  = $(this).attr('id') ;	
		var model  = $(this).attr('model') ;
			
			var curr_data = {
					action: 'smgt_edit_section',
					model : model,
					cat_id:cat_id,			
					dataType: 'json'
					};
					
					$.post(smgt.ajax, curr_data, function(response) {					
						$(".table tr#cat-"+cat_id).html(response);
						return true;				
					});			
		
});

$("body").on("click", ".btn-cat-update", function(){	
		if($.trim($('#section_name').val()) == '')
   		{
      		alert('Input can not be left blank');
      		return false;
   		}	
		var cat_id  = $(this).attr('id') ;	
		var model  = $(this).attr('model') ;
		var section_name = $("#section_name").val();
		if(confirm(language_translate2.edit_record_alert))
		{
			var curr_data = {
							action: 'smgt_update_section',
							model : model,
							cat_id:cat_id,			
							section_name:section_name,			
							dataType: 'json'
							};
							
							$.post(smgt.ajax, curr_data, function(response) {						
								
								$(".table tr#cat-"+cat_id).html(response);
								return true;				
			});			
		}
});

$("body").on("click", ".btn-cat-update-cancel", function(){		
		var cat_id  = $(this).attr('id') ;	
		var model  = $(this).attr('model') ;
		var section_name = $("#section_name").val();
	var curr_data = {
					action: 'smgt_update_cancel_section',
					model : model,
					cat_id:cat_id,			
					section_name:section_name,			
					dataType: 'json'
					};
					
					$.post(smgt.ajax, curr_data, function(response) {						
						
						$(".table tr#cat-"+cat_id).html(response);
						return true;				
	});			
		
});
	$("body").on("click", "#view_member_bookissue_popup", function(event){
				

			  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			  var docHeight = $(document).height(); //grab the height of the page
			  var scrollTop = $(window).scrollTop();
			  var idtest  = $(this).attr('idtest');
			   
				//alert(idtest);
			   var curr_data = {
			 					action: 'smgt_student_view_librarryhistory',
			 					student_id: idtest,
			 					dataType: 'json'
			 					};	 	
													
			 					$.post(smgt.ajax, curr_data, function(response) { 	
			 						//alert(response);	 
									
			 					$('.popup-bg').show().css({'height' : docHeight});							
								$('.invoice_data').html(response);	
								return true; 					
			 					});	
			
		  });
		  
    //---------Book return popup----------
	
		$("body").on("click", "#accept_returns_book_popup", function(event){
			event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			var docHeight = $(document).height(); //grab the height of the page
			var scrollTop = $(window).scrollTop();
			var idtest  = $(this).attr('idtest');			   
				//alert(idtest);
				var curr_data = {
			 		action: 'smgt_accept_return_book',
			 		student_id: idtest,
			 		dataType: 'json'
			 	};	 	
													
				$.post(smgt.ajax, curr_data, function(response) { 	
					$('.popup-bg').show().css({'height' : docHeight});							
					$('.invoice_data').html(response);	
					return true; 					
			 	});	
			
		  });
	
	
    //---------END Book return popup----------
		  
		  
		  
		  
		  // get auto book return date
	$(".issue_period,#issue_date").change(function(){
		var selection = $(".issue_period").val();
		if(selection=='')
		{
			return false;
		}
		var optionval = $(this);
		var curr_data = {
			action: 'smgt_get_book_return_date',
			issue_period: $(".issue_period").val(),			
			issue_date: $("#issue_date").val()			
		};
		$.post(smgt.ajax, curr_data, function(response) {
			$('#return_date').val(response);
		});
		
	});
		  
	$("#subject_teacher").change(function(){
		 
		$('#subject_class').html('');
		//alert(curr_data);
		 var teacher_id = $("#subject_teacher").val();
		// alert(selection);
		var optionval = $(this);
			var curr_data = {
					action: 'smgt_class_by_teacher',
					teacher_id: teacher_id,			
					dataType: 'json'
					};
					
					
					$.post(smgt.ajax, curr_data, function(response) {
						
						
					
					$('#subject_class').append(response);	
					});					
	});
	
	$("#teacher_by_class").change(function(){
		 
		$('#class_teacher').html('');
		//alert(curr_data);
		 var class_id = $("#teacher_by_class").val();
		// alert(selection);
		var optionval = $(this);
			var curr_data = {
					action: 'smgt_teacher_by_class',
					class_id: class_id,			
					dataType: 'json'
					};
					
					
					$.post(smgt.ajax, curr_data, function(response) {
						$('#class_teacher').append(response);	
					});					
	});
	



// Get All class wise student
	
 $("#class_list").change(function()
 {
	// $('#subject_list').html('');		
	var selection = $("#class_list").val();	
	var optionval = $(this);
	var curr_data = {
		action: 'smgt_load_class_student',
		class_list: $("#class_list").val(),			
		dataType: 'json'
	};
	
	$.post(smgt.ajax, curr_data, function(response) {
		$('#class_student_list').append(response);
	});
});
	
/* Message Module*/
$("#message_form #class_list_id,#message_form #send_to,#message_form #class_section_id").change(function()
{
	var current_action = $(this).attr('id');	
	var send_to = $("#send_to").val();		
	var class_list = $("#class_list_id").val();	
	var class_section = $("#class_section_id").val();	
	var class_selection_type = $(".class_selection_type").val();
	
	$('.class_selection_type').prop('selectedIndex',0);
	$(".multiple_class_div").hide();
	 
	if(current_action == 'send_to')
	{	
		class_section = '';		
		$("#class_section_id").html('');	
	}
	
	if(current_action == 'class_list_id')
	{
		
		class_section = '';
		$("#class_section_id").html('');	
	}
	
	var curr_data = {
		action: 'smgt_sender_user_list',
		send_to: send_to,			
		class_list: class_list,			
		class_section: class_section,			
		dataType: 'json'
	};
	
	if(send_to == 'supportstaff' || send_to == 'administrator')
	{
		$(".class_section_id").hide();
		$('.class_list_id').hide();
		$('.class_selection').hide();
		$(".support_staff_user_div").show();
	}
	
	if(send_to == 'teacher')
	{
		$(".class_list_id").show();
		$('.class_section_id').hide();
		$('.class_selection').show();
		$(".single_class_div").show();	
	}
	if(send_to == 'student' || send_to == 'parent')
	{
		$(".class_list_id").show();
		$('.class_section_id').show();
		$('.class_selection').show();
		$(".single_class_div").show();	
	}
$.post(smgt.ajax, curr_data, function(response) {

 var json_obj = $.parseJSON(response);//parse JSON			 
 if((send_to == 'student' || send_to == 'parent') && (current_action == 'send_to' || current_action == 'class_list_id'))
{
	$('#class_section_id').html('');
	$('#class_section_id').append(json_obj['section']);
}			
	$('.user_display_block').html('');
	$('.user_display_block').append(json_obj['users']);
	jQuery('#selected_users').multiselect({ 
	nonSelectedText :'Select Users',
	includeSelectAllOption: true,
	enableFiltering: true,
	enableCaseInsensitiveFiltering: true
});
return false;
		
	});
});
$(".class_selection_type").change(function()
{
	var class_selection_type = $(this).val();	
	var send_to = $("#send_to").val();		
	if(class_selection_type == 'multiple')
	{
		$(".multiple_class_div").show();
		$('.single_class_div').hide();
		$('.class_section_id').hide();		
	}
	else
	{
		$(".single_class_div").show();
		if(send_to == 'teacher')
		{
			$(".class_section_id").hide();
		}
		else
		{			
			$(".class_section_id").show();
		}
		$('.multiple_class_div').hide();
	}		
});	
$("body").on("click","#profile_change",function() {
			
			//event.preventDefault(); // disable normal link function so that it doesn't refresh the page
			 var docHeight = $(document).height(); //grab the height of the page
			var scrollTop = $(window).scrollTop();
		   //alert(evnet_id);
			 var curr_data = {
						action: 'smgt_change_profile_photo',
						dataType: 'json'
						};					
						
						$.post(smgt.ajax, curr_data, function(response) {	
						$('.popup-bg').show().css({'height' : docHeight});
							$('.profile_picture').html(response);	
						});
		});



/* ===================  Frant Message Module  =====================  */
/*
$("#message_form #class_list_id,#message_form #send_to,#message_form #class_section_id").change(function(){
	var current_action = $(this).attr('id');	
	var send_to = $("#send_to").val();	
	var class_list = $("#class_list_id").val();	
	var class_section = $("#class_section_id").val();	

	if(current_action == 'send_to')
	{
		
		class_section = '';
		
		$("#class_section_id").html('');	
	}
	if(current_action == 'class_list_id')
	{
		
		class_section = '';
		$("#class_section_id").html('');	
	}
	var curr_data = {
		action: 'smgt_sender_user_list',
		send_to: send_to,			
		class_list: class_list,			
		class_section: class_section,			
		dataType: 'json'
	};
	if(send_to == 'supportstaff')
	{
		$(".class_section_id").hide();
		$('.class_list_id').hide();
	}
	if(send_to == 'teacher')
	{
		$(".class_list_id").show();
		$('.class_section_id').hide();
	}
	if(send_to == 'student' || send_to == 'parent')
	{
		$(".class_list_id").show();
		$('.class_section_id').show();
	}
	$.post(smgt.ajax, curr_data, function(response) {
		
		//$('#class_student_list').html('');
		//$('#class_student_list').append(response);
	//	return false;
			 var json_obj = $.parseJSON(response);//parse JSON	
			// alert(json_obj);
			
			 if((send_to == 'student' || send_to == 'parent') && (current_action == 'send_to' || current_action == 'class_list_id'))
	{
	$('#class_section_id').html('');
						$('#class_section_id').append(json_obj['section']);
	}
				
						$('.user_display_block').html('');
						$('.user_display_block').append(json_obj['users']);
									 $('#selected_users').multiselect({ 
									 nonSelectedText :'Select Users',
									 includeSelectAllOption: true});
			return false;
		
	});
});
	*/
	$(".class_in_student").change(function()
	{
		
		var class_id = $(".class_in_student").val();
		
			 var curr_data = {
						action: 'smgt_count_student_in_class',
						class_id: class_id,
						dataType: 'json'
						};					
						$.post(smgt.ajax, curr_data, function(response) 
						{
						var json_obj = $.parseJSON(response);//parse JSON	
						if(json_obj[0] == 'class_full')
						{
							alert(language_translate2.class_limit_alert);
							window.location.reload(true);
						}
						return false;
						});
	});
	//Event And task display model
  $("body").on("click", ".show_task_event", function(event)
  {
	
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  var id  = $(this).attr('id') ;
	  var model  = $(this).attr('model') ;
	/* alert(id);
	alert(model);
	return false;   */
	   var curr_data = {
	 					action: 'smgt_show_event_task',
	 					id : id,
	 					model : model,
	 					dataType: 'json'
	 					};	
										
	 					$.post(smgt.ajax, curr_data, function(response) { 	
							 /*  alert(response);
							return false;  */    
							$('.popup-bg').show().css({'height' : docHeight});
							$('.task_event_list').html(response);	
												
							return true; 					
						});		 
	});
	$("body").on("click", ".event_close-btn", function()
	{		
		$('.popup-bg').hide(); // hide the overlay
	}); 
	
	//------------------- ADDREMOVE CATEGORY -----------------//
  
  $("body").on("click", "#addremove_cat", function(event)
  {	  
	 
	 event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  var model  = $(this).attr('model') ;
	/*   alert(model);
	 return false;   */
	   var curr_data = {
	 					action: 'smgt_add_or_remove_category_new',
	 					model : model,
	 					dataType: 'json'
	 					};	
										
	 					$.post(smgt.ajax, curr_data, function(response) { 	
						  /* alert(response);
							return false;    */
							$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
							return true; 					
	 					});		
  });

//--------------- ADD CATEGORY NAME -------------------//  
   $("body").on("click", "#btn-add-cat_new", function()
   {	
		var category_name  = $('#category_name').val();
		var model  = $(this).attr('model');
		if(category_name == 0)
		{
			// alert("You must fill out the field!");
			alert(language_translate2.category_alert);
			return false;
		}
		
		if(category_name != "")
		{	 
			var curr_data = {
					action: 'smgt_add_category_new',
					model : model,
					category_name: category_name,			
					dataType: 'json'
					};
					
					$.post(smgt.ajax, curr_data, function(response) { 	
						/* 	alert(response);
							return false; */
							var json_obj = $.parseJSON(response);//parse JSON	
						 
							$('.category_listbox_new .table').append(json_obj[0]);
							$('#category_name').val("");
							
							jQuery('.'+model).append(json_obj[1]);
							//jQuery('#'+model).append(json_obj[1]);	
						return false;					
					});	
		}
		else
		{
			 
			if(model == "room_category")
			{
				alert(language_translate2.enter_room_alert);
			}
			else
			{
				alert(language_translate2.enter_value_alert);
			}
		} 
	});
	//---------- DELETE CATEGORY -----------//	
	$("body").on("click", ".btn-delete-cat_new", function()
	{		
		var cat_id  = $(this).attr('id') ;	
		var model  = $(this).attr('model') ;
		 
		if(confirm(language_translate2.delete_record_alert))
		{
			var curr_data = {
					action: 'smgt_remove_category_new',
					model : model,
					cat_id:cat_id,			
					dataType: 'json'
					};
					 
					$.post(smgt.ajax, curr_data, function(response) { 	
                        
						jQuery('#cat_new-'+cat_id).hide();
						$('.'+model).find('option[value='+cat_id+']').remove();
						return true;				
					});			
		}
	});
	  
	$("body").on("click", ".show-admission-popup", function(event){	
		var student_id = $(this).attr('student_id') ;
		/* alert(student_id);
		return false; */
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling
		
		
		var curr_data = {
			action: 'smgt_admissoin_approved',
			student_id: student_id,			
			dataType: 'json'
		};
				
		$.post(smgt.ajax, curr_data, function(response) {
			/* alert(response);
			return false; */
			$('.popup-bg').show().css({'height' : docHeight});
			$('.result').html(response);	
						
		});	
	});
	$("#class_id_homework").change(function()
	{
		$('#student_list').html('');		
		$('#subject_list').html('');		
		$('#section_id_homework').html('');		
		var selection = $("#class_id").val();	
		var optionval = $(this);
		var curr_data = {
				action: 'smgt_load_students_homework',
				class_list: $("#class_id_homework").val(),			
				dataType: 'json'
				};
				$.post(smgt.ajax, curr_data, function(response) 
				{
					var json_obj = $.parseJSON(response);//parse JSON	
					$('#section_id_homework').append(json_obj[1]);	
					$('#subject_list').append(json_obj[2]);	
					$('#student_list').append(json_obj[0]);
					$('#student_list').multiselect('rebuild');
					$('#student_list').multiselect({enableClickableOptGroups: true,  includeSelectAllOption: true, disableIfEmpty: true});
				});
	});

	$("#section_id_homework").change(function()
	{
		$('#student_list').html('');	
		$('#subject_list').html('');		
		var selection = $("#class_id").val();	
		var optionval = $(this);
			var curr_data = {
			action: 'smgt_load_sections_students_homework',
			section_id: $("#section_id_homework").val(),			
			dataType: 'json'
			};
			$.post(smgt.ajax, curr_data, function(response) {
				var json_obj = $.parseJSON(response);
				$('#student_list').append(json_obj[0]);
				$('#subject_list').append(json_obj[1]);	
				$('#student_list').multiselect('rebuild');
				$('#student_list').multiselect({enableClickableOptGroups: true,  includeSelectAllOption: true, disableIfEmpty: true});
			});		
	});
		//------------- LOAD EXAM HALL RECEIPT --------------//
	
	
	$("body").on("change", ".exam_hall_receipt", function(event){
		$('.exam_hall_receipt_div').html('');			
		var exam_id = $("#exam_id").val();
		 
		var curr_data = {
			action: 'smgt_load_exam_hall_receipt_div',
			exam_id : exam_id,			
			dataType: 'json'
		};	
		$.post(smgt.ajax, curr_data, function(response) {
		//console.log(response);  
		  // alert(response); 	
		//return false;   
			var json_obj = $.parseJSON(response);
			
			$('.exam_hall_receipt_div').append(json_obj[0]);
			/* $('.exam_hall_table').DataTable({ 
				"destroy": true,
				  responsive: true,   // enable responsive
            });	 */
		});
	});
	//--------------- INSERT RECEIPT --------//
	$("body").on("click",".assign_exam_hall",function() 
	{
		 
		var exam_hall=$("#exam_hall").val();
		// var exam_hall_capacity="<php echo smgt_get_hall_capacity("+ exam_hall"); ?>";
		// alert(exam_hall_capacity);
		if ($('#exam_hall').val() != '')
		{
			
			if($(".my_check").is(":checked")) 
			{
				var id_array= $('.my_check:checked').map(function() {
						return this.attributes.dataid.textContent;
					}).get() 
				var array_leangth = id_array.length;
				var exam_hall_capacity = $("#exam_hall_capacity_"+exam_hall).attr("hall_capacity");
				// get_id = JSON.stringify(id_array);
				//var exam_hall = $("#exam_hall").val();
				var rowCount = $('#approve_table tbody tr').length;
				if (array_leangth > exam_hall_capacity) 
				{
					alert("Exam Hall Capacity "+ exam_hall_capacity +" Students only");
				}
				else if(rowCount >= exam_hall_capacity)
				{
					alert("Exam Hall Capacity "+ exam_hall_capacity +" Students only");
				}
				else 
				{
					var exam_id = $("#exam_id").val();
					var curr_data = {
						action: 'smgt_add_receipt_record',
						exam_hall : exam_hall,			
						exam_id : exam_id,			
						id_array : id_array,			
						dataType: 'json'
					};	
					$.post(smgt.ajax, curr_data, function(response) {
						/* console.log(response); */
						/* alert(response); 
						return false;	 */			
						var json_obj = $.parseJSON(response);
						$('#approve_table').append(json_obj[0]);
						$(".no_data_td_remove1").hide();
						$.each( id_array, function( key, value ) {
							jQuery('#not_approve_table tr#'+value).remove();
						});
					});
				}
			}
			else
			{
				alert(language_translate2.one_record_alert);
				return false;
			}
		}
		else
		{
			alert(language_translate2.select_hall_alert);
			return false;
		}
	}); 
	//--------------- DELETE RECEIPT --------//
	 $("body").on("click",".delete_receipt_record",function() {
		
		var record_id= $(this).attr('id');
		var exam_id = $("#exam_id").val();
		if(confirm(language_translate2.delete_record_alert))
		{
			var curr_data = {
					action: 'smgt_delete_receipt_record',
					record_id:record_id,			
					exam_id:exam_id,			
					dataType: 'json'
					};
					
					$.post(smgt.ajax, curr_data, function(response) {
						var json_obj = $.parseJSON(response);
						$('#not_approve_table').append(json_obj[0]);
						jQuery('#approve_table tr#'+record_id).remove();
						 $(".no_data_td_remove").hide();
					});			
		}
	}); 
	
	//----------------- VIEW PAGE POPUP ----------------//
	jQuery("body").on("click", ".view_details_popup", function(event)
	{

		  var record_id = $(this).attr('id');
		  var type = $(this).attr('type');
		
		  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		  var docHeight = $(document).height(); //grab the height of the page
		  var scrollTop = $(window).scrollTop();
		   
		   var curr_data = {
		 					action: 'smgt_view_details_popup',
		 					record_id: record_id,			
		 					type: type,			
		 					dataType: 'json'
		 					};
		 					//alert('hello');
		 					$.post(smgt.ajax, curr_data, function(response) {
							  /* alert(response);
								return false;  */
		 						$('.popup-bg').show().css({'height' : docHeight});
								$('.view_popup').html(response);	
		 						return true;
		 						
		 					});	
	});
	//------------------ EDIT POPUP CATEGORY --------------//
		$("body").on("click", ".btn-edit-cat_popup", function(){		
		var cat_id  = $(this).attr('id') ;	
		var model  = $(this).attr('model') ;
			/* alert(cat_id);
			alert(model);
			die; */
			var curr_data = {
					action: 'smgt_edit_popup_value',
					model : model,
					cat_id:cat_id,			
					dataType: 'json'
					};
					
					$.post(smgt.ajax, curr_data, function(response) {
						/* alert(response);
						die;	 */					
						$(".table tr#cat_new-"+cat_id).html(response);
						return true;				
					});			
		
		});
		
		//------------ IF CANCEL EDIT POPUP ----------//
		
			$("body").on("click", ".btn-cat-update-cancel_popup", function(){		
			var cat_id  = $(this).attr('id') ;	
			var model  = $(this).attr('model') ;
			var category_name = $("#category_name").val();
			var curr_data = {
					action: 'smgt_update_cancel_popup',
					model : model,
					cat_id:cat_id,			
					category_name:category_name,			
					dataType: 'json'
					};
					
					$.post(smgt.ajax, curr_data, function(response) {
						$('.category_listbox_new .table tbody').html(response);
						return false;				
			});			
		
		});
	
		//------------ UPDATE VALUE POPUP CATEGORY -----------------//
		$("body").on("click", ".btn-cat-update_popup", function()
		{
			if($.trim($('#category_name').val()) == '')
	   		{
	      		alert('Input can not be left blank');
	      		return false;
	   		}	
			var cat_id  = $(this).attr('id') ;	
			var model  = $(this).attr('model') ;
			var category_name = $("#category_name").val();
				if(confirm(language_translate2.edit_record_alert))
				{
					var curr_data = {
							action: 'smgt_update_cetogory_popup_value',
							model : model,
							cat_id:cat_id,			
							category_name:category_name,			
							dataType: 'json'
							};
							
							$.post(smgt.ajax, curr_data, function(response) {
								
							var json_obj = $.parseJSON(response);//parse JSON	
							 		
							$(".table tr#cat_new-"+cat_id).html(json_obj[0]);
							 
							$('.'+model+' option[value='+cat_id+']').text("");
							 
							$('.'+model).find('option[value='+cat_id+']').append(json_obj[1]);
						 				
							return true;													
							 
						});			
				}
		});

	$("body").on("click", ".show-popup", function(event)
	{
		var route_id = $(this).attr('id') ;		
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling
		var curr_data = {
			action: 'create_meeting',
			route_id: route_id,			
			dataType: 'json'
		};
		
		$.post(smgt.ajax, curr_data, function(response) {
			//alert(response);
			/* console.log(response);
			return false;  */
			$('.popup-bg').show().css({'height' : docHeight});
			$('.create_meeting_popup').html(response);	
		});	
	});

	$("body").on("click", ".show-popup", function(event)
	{
		var meeting_id = $(this).attr('meeting_id') ;		
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling
		var curr_data = {
			action: 'view_meeting_detail',
			meeting_id: meeting_id,			
			dataType: 'json'
		};
		
		$.post(smgt.ajax, curr_data, function(response) {
			//alert(response);
			/* console.log(response);
			return false;  */
			$('.popup-bg').show().css({'height' : docHeight});
			$('.view_meeting_detail_popup').html(response);	
		});	
	});
	
	
		
});