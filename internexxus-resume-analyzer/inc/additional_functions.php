<?php

//acf theme page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Resume Analyzers Felids',
		'menu_title'	=> 'Resume Analyzers Felids',
		'menu_slug' 	=> 'resume-analyzers-felids',
		'capability'	=> 'edit_posts',
		'redirect'		=> 'false',
        'menu_icon'     => 'dashicons-feedback'
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Landing Page',
		'menu_title'	=> 'Landing Page',
		'parent_slug'	=> 'resume-analyzers-felids',
	));
    acf_add_options_sub_page(array(
		'page_title' 	=> 'Upload Page',
		'menu_title'	=> 'Upload Page',
		'parent_slug'	=> 'resume-analyzers-felids',
	));
	
    acf_add_options_sub_page(array(
		'page_title' 	=> 'Analyzer Page',
		'menu_title'	=> 'Analyzer Page',
		'parent_slug'	=> 'resume-analyzers-felids',
	));
	
}	



function resume_file_upload() {
    // Check if a file was uploaded
    if (isset($_FILES['resume_file'])) {
        $uploaded_image = $_FILES['resume_file'];

        // Check for errors during the upload
        if ($uploaded_image['error'] === UPLOAD_ERR_OK) {
            // Handle the uploaded file here
            // For example, move it to a specific directory and update user meta with the attachment ID

            $upload_overrides = array('test_form' => false);
            $file_info = wp_handle_upload($uploaded_image, $upload_overrides);

            if (!isset($file_info['error'])) {
                // File successfully uploaded, now let's add it to the media library
                $attachment = array(
                    'post_mime_type' => $file_info['type'],
                    'post_title' => sanitize_file_name($file_info['file']),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment($attachment, $file_info['file']);

                // Check if attachment ID was successfully created
                if (!is_wp_error($attach_id)) {

                    echo $attach_id;

                    $current_user_id = get_current_user_id();


                    update_user_meta($current_user_id, 'working_cv_id', $attach_id);

                    // setcookie('attchment_id', '', time() + 86400, "/");

                    // setcookie('attchment_id', $attach_id, time() + 86400, "/");

                } else {
                    // Return error response if attachment ID creation fails
                    wp_send_json_error('Error creating attachment.');
                }
            } else {
                // Return error response if file upload fails
                wp_send_json_error('Error uploading file.');
            }
        } else {
            // Return error response if file upload has errors
            wp_send_json_error('File upload error.');
        }
    } else {
        // Return error response if no file was uploaded
        wp_send_json_error('No file uploaded.');
    }

    // Always exit after processing AJAX requests.
    wp_die();
}
add_action('wp_ajax_resume_file_upload', 'resume_file_upload');
add_action('wp_ajax_nopriv_resume_file_upload', 'resume_file_upload');





add_action('wp_ajax_download_ai_resume', 'download_ai_resume_cb');
add_action('wp_ajax_nopriv_download_ai_resume', 'download_ai_resume_cb');

function download_ai_resume_cb() {
    // Ensure that the attachment ID is available in the cookies
    // if (!isset($_COOKIE['attchment_id'])) {
    //     echo 'Attachment ID not found.';
    //     wp_die();
    // }

    $current_user_id = get_current_user_id();

    $resumeID = get_user_meta($current_user_id, 'working_cv_id', true);

    //$resumeID = sanitize_text_field($_COOKIE['attchment_id']);
    $attachment_url = wp_get_attachment_url($resumeID);

    if (!$attachment_url) {
        echo 'Attachment URL not found.';
        wp_die();
    }

    $options = $_POST['options'];

    $data = array(
        "link" => $attachment_url,
        "changes" => $options,
    );

    $json_body = json_encode($data, JSON_PRETTY_PRINT);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://rkeolw6wyh.execute-api.us-west-1.amazonaws.com/default/resume-builder',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $json_body,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($http_code != 200 || !$response) {
        echo 'Error fetching PDF. HTTP Code: ' . $http_code;
        wp_die();
    }

    $response_data = json_decode($response);

    $returnData = [];
    
    if($response_data){
        if($response_data->statusCode == '200'){
            $tmpData = $response_data->body;
        }else{
            $tmpData =  "403";
        }
    
         //$response_data->body;

         $returnData['downloadLink'] =  $tmpData;
    }


    $current_user_id = get_current_user_id();
    $userId = $current_user_id;
    $userMembershipLevel = pmpro_getMembershipLevelForUser($current_user_id);

    if($userMembershipLevel->id == '5'){
      
        global $wpdb;
        $tablename = $wpdb->prefix.'pmpro_membership_orders';

           // Replace with the desired user ID
        $query = $wpdb->prepare("
        SELECT `timestamp` 
            FROM $tablename 
            WHERE user_id = %d 
            ORDER BY id DESC 
            LIMIT 1
        ", $userId);

        $latest_timestamp = $wpdb->get_var($query);

        $timestamp = strtotime($latest_timestamp);

        $defineLimit = get_field('basic_plan_limit_dpp2', 'option');

        $lastP_year = date('Y', $timestamp);
        $lastP_month = date('F', $timestamp);
      
        $current_year = date('Y');
        $current_month = date('F');

        if($lastP_year == $current_year && $lastP_month == $current_month){

          $meta_key = 'download_limit_'.$lastP_month.'_'.$lastP_year;

          $getLimit = get_user_meta($userId, $meta_key, true);

          if(empty($getLimit)){
            $limit = 1;
           } elseif(!empty($getLimit) && $getLimit == 0){
            $limit = 1;
           } elseif(!empty($getLimit) && $getLimit > 0){
            $limit = $getLimit+1;
           }

           update_user_meta($userId, $meta_key, $limit);

           $returnData['downloadlimit'] = $defineLimit-$limit;
        }
    }

     echo json_encode($returnData);

    exit; 
}

add_action('wp_ajax_preview_ai_resume', 'preview_ai_resume_cb');
add_action('wp_ajax_nopriv_preview_ai_resume', 'preview_ai_resume_cb');

function preview_ai_resume_cb() {

    $current_user_id = get_current_user_id();

    $resumeID = get_user_meta($current_user_id, 'working_cv_id', true);

    if(empty($resumeID)){
        echo '403';
        wp_die();
    }

    $attachment_url = wp_get_attachment_url($resumeID);

    if (!$attachment_url) {
        echo '403';
        wp_die();
    }

    $options = $_POST['options'];

    $data = array(
        "link" => $attachment_url,
        "changes" => $options,
    );

    $json_body = json_encode($data, JSON_PRETTY_PRINT);

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://5be2xpse49.execute-api.us-west-1.amazonaws.com/default/resume_builder_preview',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>$json_body,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

   
    $response_data = json_decode($response);

    if($response_data->statusCode == '200'){
        echo $response_data->body;
    }else{
        echo "403";
    }

      exit;

}


function getScoreByCategory($data, $categoryName) {
    $categoryName = strtolower($categoryName);
    foreach ($data as $item) {
        if (strtolower($item->category) == $categoryName) {
            return $item->score;
        }
    }
    return null; // Return null if category is not found
}
function getIssuesByCategory($data, $categoryName) {
    $categoryName = strtolower($categoryName);
    foreach ($data as $item) {
        if (strtolower($item->category) == $categoryName) {
            return $item->issues;
        }
    }
    return null; // Return null if category is not found
}


function getScoreClass($score) {
    if ($score <= 50) {
        return "red";
    } elseif ($score >= 51 && $score <= 70) {
        return "orange";
    } elseif ($score >= 71 && $score <= 84) {
        return "green";
    } elseif ( $score > 84) {
        return "blue";
    }
}

?>