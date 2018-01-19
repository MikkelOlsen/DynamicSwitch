<?php
    if(isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
    }
    $validate = new Validate();
    $post = $security->secGetInputArray(INPUT_POST);
    $error = [];
    if(isset($post['btn_submit'])) {
        $pageName = $validate->characters($post['pageName'], 1, 25) ? $post['pageName'] : $error['pageName'] = '<div class="alert alert-danger">Sidenavnet skal være mellem 1 og 25 tegn.</div>';
        if(sizeof($error) == 0) {
            $result = $pages->createPage($pageName);
            var_dump($result);
            if($result === true) {
                $_SESSION['success'] = '<div class="alert alert-success">Siden <b>'.$pageName.'</b> er oprettet!</div>';
                header('Location: index.php?p=newpage');
            } else {
                $_SESSION['success'] = $result;
                header('Location: index.php?p=newpage');
            }
        }
    }

?>


<h1>Opret en ny side!</h1>
<?= @$success ?> 
<?=@$error['pageName']?>
<form method="post">
  <div class="form-group">
    <label for="pageName">Side navn</label>
    <input type="text" class="form-control" id="pageName" aria-describedby="pageName" name="pageName">
  </div>
  <button type="submit" class="btn btn-primary" name="btn_submit">Opret</button>
</form>