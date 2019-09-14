<?php
function uploader($file) {
  $target_dir = APP_ROOT . '/../public/uploads';
  if (!file_exists($target_dir)) mkdir($target_dir);

  $fileName = time() . '_' . basename($file["name"]);
  $target_file = $target_dir . '/' . $fileName;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $savedFile = URL_ROOT . '/uploads/' . $fileName;

  // Check if file already exists
  if (file_exists($target_file)) return [ 'error' => 'Sorry, file already exists.', 'path' => null ];
  // Check file size [1 MG]
  if ($file["size"] > 1000000) return [ 'error' => "Sorry, your file is too large.", 'path' => null ];
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
    return [ 'error' => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'path' => null ];

  $uploaded = move_uploaded_file($file["tmp_name"], $target_file);
  if ($uploaded) return [ 'path' => $savedFile, 'error' => null ];
}

function getFilePath($fileUrl) {
  $explodedString = explode('/', $fileUrl);
  $fileName = $explodedString[count($explodedString) - 1];
  return APP_ROOT . '/../public/uploads/' . $fileName;
}