<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once('../require/head.php'); ?>
  <title>BitBin - FAQ</title>
</head>

<body>
  <?php include_once('../require/navbar.php'); ?>

  <div class="page">
    <div class="faq">
      <h1>FAQ</h1>
    </div>
    <div class="containers">
      <ul>
        <li class="dropdown">
          <a class="nouserselect" data-toggle="dropdown">What is BitBin about?<i class="icon-arrow"></i></a>
          <ul class="dropdown-menu">
            <li><p>BitBin is about being able to share your code snippets with others in an easy way. By saving every snippet directly to our server, you are able to download files directly, copy the code from the files, or share links to the files, all with the press of a button. Because of our password feature, you can even upload private snippets and lock them, so only the people you trust can access them!</p></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="nouserselect" data-toggle="dropdown">How do I use BitBin?<i class="icon-arrow"></i></a>
          <ul class="dropdown-menu">
            <li><p>1. <br> Click on <a href="./addsnippet.php">New snippet</a> to create a new snippet.</p></li>
            <li><p>2. <br> Fill in the fields with your desired information. <br><br>Tip: If you want to keep your snippet private and only visible to certain people, you can add a password to your snippet. This way you can only check out the snippet if you have the correct password.</p></li>
            <li><p>3. <br> Click on submit to submit your snippet. You will be redirected to the homepage.</p>
            <li><p>4. <br> Find your snippet at the top of the homepage. You can also sort by name and language and you can filter by specific languages and toggle if you want to see password protected snippets. Click on <i class="fa-solid fa-copy"></i> to copy your snippet or click on the name to open the snippet.</p></li>
            <li><p>5. <br> When you have opened the snippet, you can look at the code, or click on one of the three buttons to execute one of the following actions:</p></li>
            <li><p>- Copy the link to share your code with others.</p></li>
            <li><p>- Copy the code as a file to your computer.</p></li>
            <li><p>- Download the code to your computer.</p></li>
            <li><p>6. <br> Click on supported languages to see which languages are supported and how many snippets exists of each language.</p></li>
          </ul>
        </li>
        </li>
        <li class="dropdown">
          <a class="nouserselect" data-toggle="dropdown">How can I use BitBin?<i class="icon-arrow"></i></a>
          <ul class="dropdown-menu">
            <li><p>To use BitBin, you can simply download our source code from our github, upload it to your own domain, create a database, host it, and done! Easy as that.</p></li>
          </ul>
        </li>
    </div>
  </div>
  <script src="../js/faq.js"></script>
  <?php
  include_once('../require/footer.php');
  ?>
</body>

</html>