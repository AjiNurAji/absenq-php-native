<?php
 include __DIR__ . "/../header.php"; ?>
<?php 

// get auth status
$auth = $GLOBALS["auth"] ?? null;

?>
<div class="p-6 min-h-screen flex">
  <?php include __DIR__ . "/sidebar.php"; ?>
  <main class="flex-1 lg:ml-64 w-full">
    <?php include __DIR__ . "/header.php"; ?>