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

// Handle Image File
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
