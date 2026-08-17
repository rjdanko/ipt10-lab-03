<?php

$upload_directory = getcwd() . '/uploads/';
$relative_path = '/uploads/';

// Handle Text File
if (isset($_FILES['text_file']) && $_FILES['text_file']['error'] == UPLOAD_ERR_OK) {
    $uploaded_text_file = $upload_directory . basename($_FILES['text_file']['name']);
    $temporary_file = $_FILES['text_file']['tmp_name'];

    if (move_uploaded_file($temporary_file, $uploaded_text_file)) {
        $text_file_content = file_get_contents($uploaded_text_file, 'r');
        ?>
        <textarea cols="70" rows="30"><?php echo $text_file_content; ?></textarea>
        <?php
    } else {
        echo 'Failed to upload text file';
    }
}

// Handle PDF File
if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == UPLOAD_ERR_OK) {
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
}

// Handle Audio File
if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] == UPLOAD_ERR_OK) {
    $uploaded_audio_file = $upload_directory . basename($_FILES['audio_file']['name']);
    $temporary_audio     = $_FILES['audio_file']['tmp_name'];

    if (move_uploaded_file($temporary_audio, $uploaded_audio_file)) {
        $audio_url = $relative_path . basename($_FILES['audio_file']['name']);
        ?>
        <audio controls>
            <source src="<?php echo $audio_url; ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
        <?php
    } else {
        echo 'Failed to upload audio file';
    }
}

// Handle Image File
if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == UPLOAD_ERR_OK) {
    $uploaded_image_file = $upload_directory . basename($_FILES['image_file']['name']);
    $temporary_image     = $_FILES['image_file']['tmp_name'];

    if (move_uploaded_file($temporary_image, $uploaded_image_file)) {
        $image_url = $relative_path . basename($_FILES['image_file']['name']);
        ?>
        <img src="<?php echo $image_url; ?>" alt="Uploaded Image" style="max-width: 100%;" />
        <?php
    } else {
        echo 'Failed to upload image file';
    }
}

// Handle Video File
if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] == UPLOAD_ERR_OK) {
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
}
