    <?php
    session_start();

    include_once('../require/header.php');

    if (!isset($_SESSION['sort'])) {
        $_SESSION['sort'] = '`title` ASC';
    }

    $sort = $_SESSION['sort'];

    if (isset($_SESSION['search_results'])) {
        $titlequery = $_SESSION['search_results'];
    } else {
        $titlequery = null;
    }

    if (isset($_SESSION['lang'])) {
        $langs = $_SESSION['lang'];
        $lang = implode("', '", $langs);
        if (isset($_SESSION['search_results'])) {
            $titlequery = $_SESSION['search_results'];
        } else {
            $titlequery = null;
        }
        if ($titlequery !== null) {
            $query = "SELECT * FROM `snippets` WHERE language IN ('$lang') AND $titlequery ORDER BY $sort";
        } else {
            $query = "SELECT * FROM `snippets` WHERE language IN ('$lang') ORDER BY $sort";
        }
    } else {
        if (isset($_SESSION['search_results'])) {
            $titlequery = $_SESSION['search_results'];
            $query = "SELECT * FROM `snippets` WHERE $titlequery ORDER BY $sort";
        } else {
            $query = "SELECT * FROM `snippets` ORDER BY $sort";
        }
    }


    $stmt = $conn->prepare($query);

    $stmt->execute();

    $snippets = $stmt->fetchAll();

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include_once('../require/head.php'); ?>
        <title>BitBin</title>
    </head>

    <body>
        <?php include_once('../require/navbar.php'); ?>
        <div class="page">
            <div class="dir">
                <div class="sort">
                    <div class="sort-section">
                        <form method="post" action="sort.php">
                            <label for="sort">Sort by:</label>
                            <select id="sort" name="sort">
                                <option value="`title` ASC" <?php if ($_SESSION['sort'] === "`title` ASC") echo "selected" ?>>Name (A-Z)</option>
                                <option value="`title` DESC" <?php if ($_SESSION['sort'] === "`title` DESC") echo "selected" ?>>Name (Z-A)</option>
                                <option value="`language` ASC" <?php if ($_SESSION['sort'] === "`language` ASC") echo "selected" ?>>Language (A-Z)</option>
                                <option value="`language` DESC" <?php if ($_SESSION['sort'] === "`language` DESC") echo "selected" ?>>Language (Z-A)</option>
                            </select>
                            <input type="submit" value="Sort">
                        </form>
                    </div>
                    <div class="sort-section">
                        <form class="search" method="post" action="search.php">
                            <label for="search">Search:</label>
                            <input type="text" id="search" name="search">
                            <input type="submit" value="Search">
                        </form>
                    </div>

                    <div class="sort-section">
                        <form class="reset" method="post" action="../require/resetses.php">
                            <input type="submit" id="reset" value="Reset filters">
                        </form>
                    </div>

                    <div class="sort-section">
                        <form class="check" id="showprotected" method="post" action="../require/passwordshown.php">
                            <input type="checkbox" name="showpassed" value="yes" <?php if (isset($_SESSION['showpassed']) && $_SESSION['showpassed'] === "yes") echo "checked"; ?> onchange="document.getElementById('showprotected').submit()">&nbsp;Show password protected snippets
                        </form>
                    </div>
                </div>
                <div class="sort-lang">
                    <form method="post" action="sort_lang.php">
                        <label for="">Languages</label><br>
                        <input type="checkbox" name="lang[]" value="html" <?php if (isset($_SESSION['lang']) && in_array('html', $_SESSION['lang'])) echo 'checked'; ?>> HTML<br>
                        <input type="checkbox" name="lang[]" value="css" <?php if (isset($_SESSION['lang']) && in_array('css', $_SESSION['lang'])) echo 'checked'; ?>> CSS<br>
                        <input type="checkbox" name="lang[]" value="php" <?php if (isset($_SESSION['lang']) && in_array('php', $_SESSION['lang'])) echo 'checked'; ?>> PHP<br>
                        <input type="checkbox" name="lang[]" value="sql" <?php if (isset($_SESSION['lang']) && in_array('sql', $_SESSION['lang'])) echo 'checked'; ?>> SQL<br>
                        <input type="checkbox" name="lang[]" value="js" <?php if (isset($_SESSION['lang']) && in_array('js', $_SESSION['lang'])) echo 'checked'; ?>> JavaScript<br>
                        <input type="checkbox" name="lang[]" value="py" <?php if (isset($_SESSION['lang']) && in_array('py', $_SESSION['lang'])) echo 'checked'; ?>> Python<br>
                        <input type="checkbox" name="lang[]" value="java" <?php if (isset($_SESSION['lang']) && in_array('java', $_SESSION['lang'])) echo 'checked'; ?>> Java<br>
                        <input type="checkbox" name="lang[]" value="c" <?php if (isset($_SESSION['lang']) && in_array('c', $_SESSION['lang'])) echo 'checked'; ?>> C<br>
                        <input type="checkbox" name="lang[]" value="cpp" <?php if (isset($_SESSION['lang']) && in_array('cpp', $_SESSION['lang'])) echo 'checked'; ?>> C++<br>
                        <input type="checkbox" name="lang[]" value="cs" <?php if (isset($_SESSION['lang']) && in_array('cs', $_SESSION['lang'])) echo 'checked'; ?>> C#<br>
                        <input type="checkbox" name="lang[]" value="txt" <?php if (isset($_SESSION['lang']) && in_array('txt', $_SESSION['lang'])) echo 'checked'; ?>> TXT<br>
                        <div class="submit-container"><input type="submit" value="Filter"></div>
                    </form>
                </div>
            </div>
            <div class="container">

                <?php
                if (empty($snippets)) {
                    echo "<h1>No snippets found</h1>";
                }
                if (!isset($_SESSION['showpassed'])) {
                    $_SESSION['showpassed'] = "no";
                }
                foreach ($snippets as $snippet) {
                    if ($snippet['password'] != null && $_SESSION['showpassed'] == "no") {
                        continue;
                    }
                ?>
                    <div class="snippet">
                        <div class="minicode">
                            <pre><code class="language-<?= $snippet['language'] ?>"><?php if ($snippet['password'] == null) {
                                                                                        echo htmlspecialchars($snippet['snippet']);
                                                                                    } else {
                                                                                        echo "This snippet is password protected";
                                                                                    }
                                                                                    ?></code></pre>
                        </div>
                        <div class="values">
                            <div class="first">
                                <a><?php if ($snippet['password'] != null) {
                                        echo "<i class='fa-solid fa-lock'></i>&nbsp;";
                                    } ?></a><a href="../webpages/snippet.php?id=<?= $snippet['snippet_id'] ?>"><?= $snippet['title'] ?></a>
                                <?php
                                switch ($snippet['language']) {
                                    default:
                                        $bgcolor = "grey";
                                        $lan = "TXT";
                                        break;
                                    case 'html':
                                        $bgcolor = "#f06529";
                                        $lan = "HTML";
                                        break;
                                    case 'css':
                                        $bgcolor = "#2965f1";
                                        $lan = "CSS";
                                        break;
                                    case 'php':
                                        $bgcolor = "#777bb3";
                                        $lan = "PHP";
                                        break;
                                    case 'sql':
                                        $bgcolor = "#f0ad4e";
                                        $lan = "SQL";
                                        break;
                                    case 'js':
                                        $bgcolor = "#f7df1e";
                                        $lan = "JavaScript";
                                        break;
                                    case 'py':
                                        $bgcolor = "#3572A5";
                                        $lan = "Python";
                                        break;
                                    case 'java':
                                        $bgcolor = "#b07219";
                                        $lan = "Java";
                                        break;
                                    case 'c':
                                        $bgcolor = "#555555";
                                        $lan = "C";
                                        break;
                                    case 'cpp':
                                        $bgcolor = "#f34b7d";
                                        $lan = "C++";
                                        break;
                                    case 'cs':
                                        $bgcolor = "#178600";
                                        $lan = "C#";
                                        break;
                                }
                                ?>
                                <div class="tooltip">
                                    <button class="copy" id="copy" onclick="copyClipboard('<?= $snippet['snippet_id'] ?>')"><i class="fa-solid fa-copy"></i></button>
                                    <span class="tooltiptext" id="<?= $snippet['snippet_id'] ?>">Copy link to clipboard</span>
                                </div>


                            </div>
                            <p class="lan" style="background-color: <?= $bgcolor ?>"><?php echo $lan; ?></p>
                        </div>
                    </div>

                <?php
                }

                ?>
            </div>
            <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js"></script>
            <script>
                hljs.highlightAll();
                hljs.initLineNumbersOnLoad();

                function copyClipboard(snippetid) {
                    const copied = document.getElementById(snippetid);
                    copied.innerHTML = 'Copied!';
                    const link = window.location.href;
                    const native = link.slice(0, link.lastIndexOf('/'));
                    const copyLinkInput = native + "/snippet.php?id=" + snippetid;
                    const tempInput = document.createElement('input');
                    tempInput.setAttribute('type', 'text');
                    tempInput.setAttribute('value', copyLinkInput);
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    setTimeout(function() {
                        copied.innerHTML = 'Copy to clipboard';
                    }, 1000);
                };
            </script>

        </div>
        <?php
        include_once('../require/footer.php');
        ?>
    </body>

    </html>