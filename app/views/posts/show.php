<?php require APP_ROOT . '/views/inc/header.php'; ?>

<a href="<?php echo URL_ROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
  Written by <?php echo $data['post']->name; ?> on <?php echo $data['post']->pCreatedAt; ?>
</div>
<p><?php echo $data['post']->body; ?></p>

<?php if ($_SESSION['id'] === $data['post']->userId): ?>
  <hr>
  <a href="<?php echo URL_ROOT; ?>/posts/edit/<?php echo $data['post']->postId; ?>" class="btn btn-dark">Edit</a>

  <form style="float: right" action="<?php echo URL_ROOT; ?>/posts/delete/<?php echo $data['post']->postId; ?>" method="post">
    <input type="submit" name="submit" value="Delete" class="btn btn-danger">
  </form>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>