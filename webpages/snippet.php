<?php
session_start();

if (!isset($_SERVER['HTTP_REFERER'])) {
    session_unset();
    session_destroy();
}

include_once('../require/header.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid link. Je wordt met 5 seconden teruggestuurd.";
    header("refresh:5;url=./index.php");
    exit();
} else {
    $id = $_GET['id'];
}

$query = "SELECT * FROM `snippets` WHERE snippet_id = '$id'";
$stmt = $conn->prepare($query);
$stmt->execute();

$snippet = $stmt->fetch();

if (!$snippet) {
    echo "Invalid link. Je wordt met 5 seconden teruggestuurd.";
    header("refresh:5;url=./index.php");
    exit();
}

if ((!isset($_SESSION['checked']) && $snippet['password'] != null)) {
    $_SESSION['checked'] = "false";
} else {
    $_SESSION['checked'] = "true";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('../require/head.php'); ?>
    <title>BitBin - <?= $snippet['title'] ?></title>
</head>

<div class="page">

    <body id="snippets">
        <?php include_once('../require/navbar.php'); ?>

        <h1><?= $snippet['title'] ?></h1>

        <div class="buttons">
            <div class="tooltip">
                <button <?php if ($_SESSION['checked'] != "true") {
                            echo "style='background-color: grey; cursor: not-allowed;'";
                        } ?> id="downloadButton"><a <?php if ($_SESSION['checked'] != "true") {
                                                        echo "style='pointer-events: none;'";
                                                    } ?> href="../snippets/<?= $snippet['snippet_id'] ?>.<?= $snippet['language'] ?>" download>Download</a></button>
                <?php
                if ($_SESSION['checked'] != "true") {
                    echo '<span class="tooltiptext" style="background-color: red;">Password protected</span>';
                } else { ?>
                    <span class="tooltiptext" id="spandex2">Download file</span>
                <?php } ?>
            </div>
            <div class="tooltip">
                <button id="copyButton">Copy link</button>
                <span class="tooltiptext" id="spandex">Copy link to clipboard</span>
            </div>
            <div class="tooltip">
                <button <?php if ($_SESSION['checked'] != "true") {
                            echo "style='background-color: grey; cursor: not-allowed;'";
                        } ?> id="copyCodeButton">Copy code</button>
                <?php
                if ($_SESSION['checked'] != "true") {
                    echo '<span class="tooltiptext" style="background-color: red;">Password protected</span>';
                } else { ?>
                    <span class="tooltiptext" id="spandex1">Copy code to clipboard</span>
                <?php } ?>
            </div>
        </div>

        <?php
        if (($snippet['password'] != null && $_SESSION['checked'] == "false") || ($_SESSION['checked'] != "false" && $_SESSION['checked'] != "true")) {

            echo '<div class="password">
            <h2>This snippet is password protected</h2>
            <form action="../require/checkpassword.php" method="post">
                <input type="hidden" name="id" value="' . $snippet['snippet_id'] . '">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" value="Submit">
            </form>
            </div>';
            if ($_SESSION['checked'] == "wrong") {
                echo '<div style="color: red; margin-left: 5px;">Incorrect password</div>';
            }
        } else {
            echo "<pre id='copyCode'><code class=\"language-{$snippet['language']}\">" . htmlspecialchars($snippet["snippet"]) . "</code></pre>";
        }
        ?>

        <input type="hidden" id="copyLink" name="copyLink" value="../snippets/<?= $snippet['snippet_id'] ?>.<?= $snippet['language'] ?>">
</div>

<?php
include_once('../require/footer.php');
?>

<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js"></script>
<script>
    hljs.highlightAll();
    hljs.initLineNumbersOnLoad();

    const copyButton = document.getElementById('copyButton');
    const copyLinkInput = window.location.href;

    copyButton.addEventListener('click', () => {
        const copied = document.getElementById('spandex');
        copied.innerHTML = "Copied!";
        const tempInput = document.createElement('input');
        tempInput.setAttribute('type', 'text');
        tempInput.setAttribute('value', copyLinkInput);
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        setTimeout(() => {
            copied.innerHTML = "Copy link to clipboard";
        }, 1000);
    });

    const copyCodeButton = document.getElementById('copyCodeButton');
    const copyCodeInput = document.getElementById('copyCode');

    copyCodeButton.addEventListener('click', () => {
        const copied2 = document.getElementById('spandex1');
        copied2.innerHTML = "Copied!";

        const range = document.createRange();
        range.selectNode(copyCodeInput);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);

        try {
            const successful = document.execCommand('copy');
            if (successful) {
                setTimeout(() => {
                    copied2.innerHTML = "Copy code to clipboard";
                }, 1000);
            }
        } catch (err) {
            console.error('Unable to copy', err);
        }

        window.getSelection().removeAllRanges();
    });

    const downloadButton = document.getElementById('downloadButton');

    downloadButton.addEventListener('click', () => {
        const copied3 = document.getElementById('spandex2');
        copied3.innerHTML = "Downloaded!";
        setTimeout(() => {
            copied3.innerHTML = "Download file";
        }, 1000);
    });
</script>
</body>

</html>