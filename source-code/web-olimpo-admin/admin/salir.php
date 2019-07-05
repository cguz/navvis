<?
      session_start();
      session_unset();
      session_destroy();
      echo "<script>document.location.href='index.php'</script>";

?>