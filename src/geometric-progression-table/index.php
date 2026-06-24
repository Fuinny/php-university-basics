<!DOCTYPE html>
<html lang="lt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Geometrijos Progresija</title>
        <script>
            function changeColor(cell) {
                if (cell.style.backgroundColor === 'yellow') {
                    cell.style.backgroundColor = 'white';
                } else {
                    cell.style.backgroundColor = 'yellow';
                }
            }
        </script>
    </head>
    <body class="bg-light">
        <div class="container my-5">
            <h1 class="text-center mb-4">Geometrijos Progresija</h1>
            <?php
                define("FIRST_NUMBER", 2);
                define("MULTIPLIER", 2);
                define("NUMBER_OF_ELEMENTS", 12);

                $cellSum = 0;
                $cellCount = 0;

                echo "<table class='table table-bordered text-center table-hover'>";
                echo "<thead class='table-dark'><tr><th colspan='3'>Geometrijos Progresija</th></tr></thead>";
                echo "<tbody>";

                while ($cellCount < NUMBER_OF_ELEMENTS) {
                    if ($cellCount % 3 == 0) {
                        echo "<tr>";
                    }

                    $currentNumber = FIRST_NUMBER * pow(MULTIPLIER, $cellCount);
                    $cellSum += $currentNumber;

                    echo "<td onclick='changeColor(this)'>$currentNumber</td>";

                    if ($cellCount % 3 == 2) {
                        echo "</tr>";
                    }

                    $cellCount++;
                }

                if (!($cellCount % 3 == 2)) {
                    echo "</tr>";
                }

                echo "<tr><td colspan='3' class='bg-warning'>Suma: $cellSum</td></tr>";
                echo "</tbody></table>";
            ?>
        </div>
    </body>
</html>
