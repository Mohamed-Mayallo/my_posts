<?php require APP_ROOT . '/views/inc/header.php'; ?>

  <a href="<?php echo URL_ROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <div class="card card-body bg-light mt-5">
    <h2>Add Post</h2>
    <p>Create a post with this form</p>
    <form action="<?php echo URL_ROOT . '/posts/add'; ?>" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Title: <sup>*</sup></label>
        <input type="text" required name="title" class="form-control form-control-lg <?php echo ($data['title_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="body">Body: <sup>*</sup></label>
        <textarea name="body" required class="form-control form-control-lg <?php echo ($data['body_err']) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
      </div>
      <div class="form-group">
        <div class="custom-file">
          <input type="file" name="image" class="custom-file-input <?php echo ($data['image_err']) ? 'is-invalid' : ''; ?>" id="imageFile" required>
          <label class="custom-file-label" for="imageFile">Choose file...</label>
          <div class="invalid-feedback"><?php echo $data['image_err']; ?></div>
        </div>
      </div>
      <input type="submit" name="submit" class="mt-4 btn btn-success" value="Add post">
    </form>
  </div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>