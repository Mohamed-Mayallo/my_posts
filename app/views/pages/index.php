<?php require_once APP_ROOT . '/views/inc/header.php'; ?>

<div class="jumbotron jumbotron-flud">
  <div class="container">
    <?php if (isset($_SESSION['id'])): ;?>
      <h1 class="display-3">Hello <?php echo $_SESSION['name']; ?></h1>
    <?php else: ;?>
      <h1 class="display-3">Hello Guest</h1>
    <?php endif; ?>
  </div>
</div>

<?php require_once APP_ROOT . '/views/inc/footer.php'; ?>