<?php

$upload_directory = getcwd() . '/uploads/';
$relative_path = '/uploads/';

// Handle Text File
$uploaded_text_file = $upload_directory . basename($_FILES['text_file']['name']);
$temporary_file = $_FILES['text_file']['tmp_name'];

if (move_uploaded_file($temporary_file, $uploaded_text_file)) {
    $text_file_content = file_get_contents($uploaded_text_file, 'r');
    ?>
    <textarea cols="70" rows="30"><?php echo $text_file_content; ?></textarea>
    <?php
} else {
    echo 'Failed to upload file';
}

$uploaded_pdf_file = $upload_directory . basename($_FILES['pdf_file']['name']);
$temporary_pdf     = $_FILES['pdf_file']['tmp_name'];
if (move_uploaded_file($temporary_pdf, $uploaded_pdf_file)) {
    $pdf_url = $relative_path . basename($_FILES['pdf_file']['name']);
    ?>
    <embed src="<?php echo $pdf_url; ?>" type="application/pdf" width="100%" height="600px" />
    <?php
} else {
    echo 'Failed to upload PDF file';
}

// Handle Video File
$uploaded_video_file = $upload_directory . basename($_FILES['video_file']['name']);
$temporary_video     = $_FILES['video_file']['tmp_name'];

if (move_uploaded_file($temporary_video, $uploaded_video_file)) {
    $video_url = $relative_path . basename($_FILES['video_file']['name']);
    ?>
    <video width="640" height="360" controls>
        <source src="<?php echo $video_url; ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <?php
} else {
    echo 'Failed to upload video file';
}
