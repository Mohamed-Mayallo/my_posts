<?php require APP_ROOT . '/views/inc/header.php'; ?>

  <a href="<?php echo URL_ROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <div class="card card-body bg-light mt-5">
    <h2>Edit Post</h2>
    <p>Edit post with this form</p>
    <form action="<?php echo URL_ROOT; ?>/posts/edit/<?php echo $data['postId']; ?>" method="post">
      <div class="form-group">
        <label for="title">Title: <sup>*</sup></label>
        <input type="text" name="title" class="form-control form-control-lg <?php echo ($data['title_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="body">Body: <sup>*</sup></label>
        <textarea name="body" class="form-control form-control-lg <?php echo ($data['body_err']) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
      </div>
      <input type="submit" name="submit" class="btn btn-success" value="Edit post">
    </form>
  </div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>