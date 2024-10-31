function openForm() {

  document.getElementById("myForm").style.display = "block";
  jQuery('.add_post_messages').html('');
  jQuery('.input_area').html('');
  jQuery('.add_post_messages').addClass('loadingBot');

    jQuery.ajax({
	    type:'POST',
	    url: ajax.url,
	    data:{action:'aspc_get_msgs'},
	    success:function(response){
	    	var data = jQuery.parseJSON(response);
	    	jQuery('.input_area').html('');
	    	jQuery('.add_post_messages').html('');
	    	jQuery('.add_post_messages').append(data.msg);
  			jQuery('.input_area').append(data.input);
  			jQuery('.add_post_messages').removeClass('loadingBot');
  			jQuery('#add_post_send').prop("disabled", true);
  		},
	    error: function(response){
	        jQuery('.add_post_messages').removeClass('loadingBot');
	    }
	});
}
jQuery('body').on('keypress','.input_area input',function (e) {
	
  if (e.which == 13) {
  	if (jQuery(this).val() != '') {
		jQuery('#add_post_send').trigger('click');
		return false;
  	}else {
  		return false;
  	}
  }

});
jQuery('#add_post_send').click(function(event) {
	jQuery('.add_post_messages').addClass('loadingBot');
	if (jQuery('.input_area input[type="file"]').length == 1){
		BotUploadImage();
		return;
	}

	var value = jQuery('.input_area input, .input_area textarea').val();
	jQuery('.add_post_messages').append('<p class="pl-right p-title"><span>'+value+'</span></p>');
	var name = jQuery('.input_area input , .input_area textarea').attr('name');
	var step = jQuery('.input_area input , .input_area textarea').attr('data-step');
	var msg = jQuery('.add_post_messages').html();
	var conf = 2;

	setTimeout(function(){
		jQuery.ajax({
		    type:'POST',
		    url: ajax.url,
		    data:{msg:msg,value:value,step:step,name:name,action:'aspc_auto_chat_response'},
		    success:function(response){
		    	var data = jQuery.parseJSON(response);
		    	jQuery('.input_area').html('');
		    	jQuery('.add_post_messages').html('');
		    	jQuery('.add_post_messages').append(data.msg);
	  			jQuery('.input_area').append(data.input);
	  			jQuery('.add_post_messages').removeClass('loadingBot');
	        },
		    error: function(response){
		        jQuery('.add_post_messages').removeClass('loadingBot');
		    }
		});
	}, 1000);

	
	jQuery('.input_area input').val('');
	jQuery('.input_area textarea').val('');
	
});
jQuery('body').on('change','.input_area input , .input_area textarea',function(event) {
	var valu = jQuery(this).val();
	if (valu.length > 0) {
		jQuery('#add_post_send').prop("disabled", false);
	}else {
		jQuery('#add_post_send').prop("disabled", true);
	}
});

jQuery('body').on('click','.clsbtns span',function(event) {
	jQuery('.add_post_messages').addClass('loadingBot');

	var step = jQuery('.input_area input , .input_area textarea').attr('data-step');
	var conf = jQuery(this).attr('data-key');
	var value = '';
	var msg = jQuery('.add_post_messages').html();
	setTimeout(function(){
		jQuery.ajax({
		    type:'POST',
		    url: ajax.url,
		    data:{msg:msg,step:step,conf:conf,action:'aspc_auto_chat_response'},
		    success:function(response){
		    	var data = jQuery.parseJSON(response);
		    	jQuery('.input_area').html('');
		    	jQuery('.add_post_messages').html('');
		    	jQuery('.add_post_messages').append(data.msg);
	  			jQuery('.input_area').append(data.input);
	            jQuery('.add_post_messages').removeClass('loadingBot');
		    },
		    error: function(response){
		        jQuery('.add_post_messages').removeClass('loadingBot');
		    }
		});
	}, 1000);

	
	jQuery('.input_area input').val('');
	jQuery('.input_area textarea').val('');
	
});


jQuery('body').on('click','#add_new_post',function(event) {

	jQuery.ajax({
	    type:'POST',
	    url: ajax.url,
	    data:{step:0,action:'add_post_save_msg'},
	    success:function(response){
	    	var data = jQuery.parseJSON(response);
	    	jQuery('.input_area').html('');
	    	jQuery('.add_post_messages').html('');
	    	jQuery('.add_post_messages').append(data.msg);
  			jQuery('.input_area').append(data.input);
           	if (data.new == 1) {
  				jQuery('#add_post_send').hide();
  			}else {
  				jQuery('#add_post_send').show();
  			}
	    },
	    error: function(response){
	        
	    }
	});
});

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}



function BotUploadImage() {

    var fcnt = jQuery('#filecount').val();
    var fname = jQuery('#filename').val();
    var imgclean = jQuery('#Botfile');
    var msg = jQuery('.add_post_messages').html();
    
        data = new FormData();
        data.append('file', jQuery('#Botfile')[0].files[0]);
        data.append('action', 'aspc_auto_chat_response');
        data.append('step', 4);
        data.append('msg',msg);


        var imgname = jQuery('input[type=file]').val();
        var size = jQuery('#Botfile')[0].files[0].size;

        var ext = imgname.substr((imgname.lastIndexOf('.') + 1));
        if (ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'PNG' || ext == 'JPG' || ext == 'JPEG') {
            
            jQuery.ajax({
            	url: ajax.url,
                type: "POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false 
            }).done(function(response) {
            	var data = jQuery.parseJSON(response);
		    	jQuery('.input_area').html('');
		    	jQuery('.add_post_messages').html('');
		    	jQuery('.add_post_messages').append(data.msg);
	  			jQuery('.input_area').append(data.input);

	  			if (data.new == 1) {
	  				jQuery('#add_post_send').hide();
	  			}
                jQuery('.add_post_messages').removeClass('loadingBot');

            });
            return false;
            
        } else {
        	jQuery('.add_post_messages').removeClass('loadingBot');
            imgclean.replaceWith(imgclean = imgclean.clone(true));
            alert('Sorry Only you can uplaod JPEG|JPG|PNG file type ');
        }
}