<?php

include_once('../require/header.php');
$randomlink = func::randomLink();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('../require/head.php'); ?>
    <title>BitBin - Add Snippet</title>
</head>
<div class="page">

    <body>
    <?php include_once('../require/navbar.php'); ?>

        <div class="container-form">
            <div class="comment">
                <form method="post" action="./add_process.php">
                    <label for="snippet">Code</label><br>
                    <div>
                        <textarea class="textinput" required name="snippet" rows="25" cols="150" placeholder="Enter your code here..."></textarea><br>
                    </div>
                    <label for="title">Title</label><br>
                    <input class="textinput-title" type="text" name="title" required><br><br>
                    <label for="language">Language</label><br>
                    <select name="language" required>
                        <option value="" disabled selected>Select a language</option>
                        <option value="txt">Text</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="php">PHP</option>
                        <option value="sql">SQL</option>
                        <option value="js">JavaScript</option>
                        <option value="py">Python</option>
                        <option value="java">Java</option>
                        <option value="c">C</option>
                        <option value="cpp">C++</option>
                        <option value="cs">C#</option>
                    </select><br><br>
                    <div>
                        <label for="wantpassword">Password protected:</label>
                        <select name="wantpassword" id="wantpassword" required>
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select><br><br>
                    </div>

                    <div id="password-group" style="display:none;">
                        <label for="password">Password</label><br>
                        <input class="passwordinput" autocomplete="off" type="password" name="password"><br><br>
                    </div>

                    <input type="hidden" name="snippet_id" value="<?php echo $randomlink ?>">
                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>
        </div>
</div>
<?php
include_once('../require/footer.php');
?>
<script>
    const wantpasswordSelect = document.getElementById('wantpassword');
    const passwordGroup = document.getElementById('password-group');

    wantpasswordSelect.addEventListener('change', function() {
        if (this.value === '1') {
            passwordGroup.style.display = 'block';
        } else {
            passwordGroup.style.display = 'none';
        }
    });
</script>
</body>

</html>