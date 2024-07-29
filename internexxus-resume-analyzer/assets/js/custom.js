jQuery(document).ready(function($){

	var cb = document.querySelectorAll(".alert_close");
	for (i = 0; i < cb.length; i++) {
	   cb[i].addEventListener("click", function() {
		  var dia = this.parentNode.parentNode; /* You need to update this part if you change level of close button */
		  dia.style.opacity = 0;
		  dia.style.zIndex = -1;
	   });
	}

	$('#resume-file').on('change', function() {
		var fileName = $(this).val().split('\\').pop();
		//$('#file_name').text('Selected file: ' + fileName);
		if(fileName){
			$(".file_exmp p").text(fileName);
			console.log(fileName);
		}else{
			$(".file_exmp p").text('no file selected');
			console.log("no file selected");
		}
		
	});

  jQuery('#scan-resume').on('click',function(e){
	e.preventDefault();
	    // Get the selected file
		var validTypes = ['application/pdf', 'application/msword','text/plain'];
	    var file = jQuery('#resume-file').get(0).files[0];
		var maxSize = 5 * 1024 * 1024; // 5 MB in bytes
		console.log(file);
		if(file == undefined || file == null || file == ''){
			$(".required_text").text('File is not selected');
			$("#alert_fire").css('opacity','1');
			$("#alert_fire").css('z-index','9999');
			return;
		}

		var fileTypeValid = $.inArray(file.type, validTypes) >= 0;
		var fileSizeValid = file.size <= maxSize;



		if(!fileTypeValid){
			$(".required_text").text('Error: The file type you uploaded is not supported. Please upload a file with one of the following extensions: .pdf, .doc, or .txt.');
			$("#alert_fire").css('opacity','1');
			$("#alert_fire").css('z-index','9999');
			return;
		}

		if(!fileSizeValid){
			$(".required_text").text('Error: The file you uploaded exceeds the size limit. Please ensure your file is no larger than 5 MB');
			$("#alert_fire").css('opacity','1');
			$("#alert_fire").css('z-index','9999');
			return;
		}


	    // Display file name with extension
	    var fileName = file.name;
	    jQuery('#resume-name').text(fileName); // Update the text content of an element with id 'file-name'

		console.log(fileName);

	    // Create FormData object and append the file to it
	    var formData = new FormData();
	    formData.append('resume_file', file);
	    formData.append('action', 'resume_file_upload');

	    // Send AJAX request
	    jQuery.ajax({
	        type: 'POST',
	        url: ajax_object.ajaxurl,
	        data: formData,
	        contentType: false,
	        processData: false,
	        beforeSend: function() {
	            // Show a loading spinner or do something before the AJAX request is sent
	            jQuery('.loader_upload_cv').addClass('show_loader');
	        },
	        success: function(response) {
	        	jQuery('.loader_upload_cv').removeClass('show_loader');

				console.log(response);

				window.location.href = "https://internexxus.com/view-resume/";
	        	//var resume_url=response.data.attachment_url;
	        	//var resume_data=response.data.responce_data;
	            // Handle the response from the server
	            //jQuery('#resume_url').val(response);

	        
				//jQuery('#responce_data').html(generated_html);    
	        },
	        error: function(errorThrown) {
	        	jQuery('.res-loader').hide();
	            // Handle errors here
	            console.log(errorThrown);
	        }
	    });
	});

	jQuery('#download_ai_resume').on('click',function(){
		
		$(".resume_analyzer_loader").addClass('show_loader');


		var selectedCheckboxes = $(`input[name="resume_points"]:checked`);
    
		// Create an array to hold the values of the selected checkboxes
		var selectedValues = [];
		
		// Iterate over the checkboxes and push their values to the array
		selectedCheckboxes.each(function() {
			selectedValues.push($(this).val());
		});

	
		jQuery.ajax({
            url: ajax_object.ajaxurl, // WordPress AJAX URL
            type: 'POST',
            data: {
                action: 'download_ai_resume',
				'options':selectedValues,
            },
            success: function(result) {
                if (result) {
					if(result != '403'){


					var getresult = JSON.parse(result) 
					var downloadLink = getresult.downloadLink;
					var downloadLimit = getresult.downloadlimit;

					//console.log(downloadLimit);

					const a = document.createElement('a');
					a.href = downloadLink;
					document.body.appendChild(a);
					a.click();
					document.body.removeChild(a);
					 if(downloadLimit != undefined ||downloadLimit != null || downloadLimit != ''){
						$("#time_reaming_basic").text(downloadLimit);
						if(downloadLimit == "0"){
							$("#download_ai_resume").addClass('disabled_button');
						}
					 }
				   $(".resume_analyzer_loader").removeClass('show_loader');
				}else{

				$(".resume_analyzer_loader").removeClass('show_loader');
				alert("Network Timeout! Failed to download file. Please Try Again.");
				}
                } else {
                    alert('"Network Timeout! Failed to download file. Please Try Again."');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
	  
	});


		$('#preview_ai_resume').on('click', function(e) {

			$(".resume_analyzer_loader").addClass('show_loader');

			var selectedCheckboxes = $(`input[name="resume_points"]:checked`);
    
			// Create an array to hold the values of the selected checkboxes
			var selectedValues = [];
			
			// Iterate over the checkboxes and push their values to the array
			selectedCheckboxes.each(function() {
				selectedValues.push($(this).val());
			});


			console.log(selectedValues);
			//return;

			e.preventDefault();
	
			$.ajax({
				url: ajax_object.ajaxurl, // WordPress AJAX URL
				type: 'POST',
				data: {
					action: 'preview_ai_resume',
					'options':selectedValues,
				},
				success: function(response) {
					if (response) {
						console.log(response);
						if(response != '403'){
						$('.html_cv').html(response);
						// Display the modal
						$('#pdfModal').css('display', 'block');
						$(".resume_analyzer_loader").removeClass('show_loader');

						}else {
	
						// Display the modal
						$(".resume_analyzer_loader").removeClass('show_loader');
						alert("Network Timeout! Please Try Again.");
						}
						
					} else {
						alert('Failed to load PDF. Blob is empty or invalid.');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error: ' + error);
				}
			});
		});
	
		// Close the modal when the user clicks on <span> (x)
		$('#closeModal').on('click', function() {
			$('#pdfModal').css('display', 'none');
		});
	
		// Close the modal when the user clicks anywhere outside of the modal
		$(window).on('click', function(event) {
			if (event.target.id === 'pdfModal') {
				$('#pdfModal').css('display', 'none');
			}
		});
	
	
})