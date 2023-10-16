<?php include_once('../require/header.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once('../require/head.php'); ?>
    <title>BitBin - Languages</title>
</head>

<body>
    <?php include_once('../require/navbar.php'); ?>
    
    <div class="page">
        <div class="languages">
            <h1>Supported languages</h1>
            <?php
            $languages = [
                'txt' => 'Text',
                'html' => 'HTML',
                'css' => 'CSS',
                'php' => 'PHP',
                'sql' => 'SQL',
                'js' => 'JavaScript',
                'py' => 'Python',
                'java' => 'Java',
                'c' => 'C',
                'cpp' => 'C++',
                'cs' => 'C#'
            ];
            ?>
            <table id="languagesTable">
                <thead>
                    <tr>
                        <th class="nouserselect" onclick="sortTable('languagesTable')">Languages and Script Count <i class="fa-solid fa-sort"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($languages as $code => $name) {
                        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM snippets WHERE language = :language");
                        $stmt->bindParam(':language', $code);
                        $stmt->execute();
                        $result = $stmt->fetch();

                        echo "<tr><td>{$name}: {$result['count']} scripts</td></tr>";
                    }

                    $conn = null;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../js/nav.js"></script>
    <script>
        function sortTable(tableId) {
            let table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById(tableId);
            switching = true;

            let dir = "asc";
            let switchcount = 0;

            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("tr");

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[0];
                    y = rows[i + 1].getElementsByTagName("td")[0];

                    let xValue = parseInt(x.innerHTML.split(":")[1].trim().split(" ")[0]);
                    let yValue = parseInt(y.innerHTML.split(":")[1].trim().split(" ")[0]);

                    if (dir == "desc") {
                        if (xValue > yValue) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "asc") {
                        if (xValue < yValue) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount === 0 && dir === "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
    <?php
    include_once('../require/footer.php');
    ?>
</body>

</html>