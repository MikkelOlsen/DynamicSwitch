<?php
if(isset($_POST['doit'])) {
    echo '<h1>Vi er inde!</h1>';
}
    if(isset($_POST['test1'])) {
        echo 'Test1';
        echo '<form method="post">';
        echo '<input type="submit" value="Do It" name="doit">';
        echo '</form>';
        
    }
?>

<form method="post">
    <input type="text" name="test1">
    <input type="submit" value="Submit" name="submit">
</form>