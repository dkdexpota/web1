<?php
session_start();
if (isset($_SESSION["requestsCount"])) {
    for ($i = 0; $i < $_SESSION["requestsCount"]; $i++) {
        unset($_SESSION[$i."coord_x"]);
        unset($_SESSION[$i."coord_y"]);
        unset($_SESSION[$i."radius"]);
        unset($_SESSION[$i."result"]);
        unset($_SESSION[$i."time"]);
    }
    $_SESSION["requestsCount"] = 0;
}

if(!isset($_SESSION["requestsCount"])){
    $_SESSION["requestsCount"] = 0;
}
?>
<html>
	<head>
	    <meta charset="utf-8">
	    <title>Result</title>
	    <link rel="stylesheet" href="main.css">
	</head>
	<body>
		<div class="header_text">
			<div class="info_block">
				Щепелев Артур Вячеславович
			</div>
			<div class="info_block">
				P3232
			</div>
			<div class="info_block">
				Вариант: 32014
			</div>
		</div>
		<div id="box_content">
			<div id="content">
		        <table class="results">
		            <tr>
		                <th>X</th>
		                <th>Y</th>
		                <th>R</th>
		                <th>Result</th>
		                <th>Time</th>
		            </tr>
		        <?php
		        function checkPosition($coord_x, $coord_y, $radius) {
		            if ($coord_x <= 0 && $coord_y >= 0 && $coord_x + $radius >= $coord_y) {
		               return true;
		            }
		            if ($coord_x <= 0 && $coord_y <= 0 && $coord_x >= -$radius && $coord_y >= -$radius/2) {
		                return true;
		            }
		            if ($coord_x >= 0 && $coord_y <= 0 && sqrt($coord_x*$coord_x+$coord_y*$coord_y) <= $radius) {
		                return true;
		            }
		            return false;
		        }

		        function extendTable($i) {
		            echo "<tr><td>" . $_SESSION[$i."coord_x"]
		                . "</td><td>" . $_SESSION[$i."coord_y"]
		                . "</td><td>" . $_SESSION[$i."radius"]
		                . "</td><td>" . $_SESSION[$i."result"]
		                . "</td><td>" . $_SESSION[$i."time"]
		                . "</td></tr>";
		        }

		        function validateNumbers() {
		            $x_check = false;
		            if (is_numeric($_GET['coord_x']) && strlen((string)$_GET['coord_x']) <= 5) {
		                if (fmod($_GET["coord_x"], 1) == 0 && $_GET["coord_x"] >= -4 && $_GET["coord_x"] <= 4) {
		                    $x_check = true;
		                }
		            }

		            $y_check = false;
		            if (is_numeric($_GET['coord_y']) && strlen((string)$_GET['coord_y']) <= 5) {
		                if ($_GET["coord_y"] > -5 && $_GET["coord_y"] < 5) {
		                    $y_check = true;
		                }
		            }

		            $r_check = false;
		            if (is_numeric($_GET['radius']) && strlen((string)$_GET['radius']) <= 5) {
		                if (fmod($_GET["radius"], 1) == 0 && $_GET["radius"] >= 1 && $_GET["radius"] <= 5) {
		                    $r_check = true;
		                }
		            }

		            if ($x_check && $y_check && $r_check) {
		                return true;
		            }
		            return false;
		        }
		        for ($i = 0; $i < $_SESSION["requestsCount"]; $i++) {
		            extendTable($i);
		        }

		        if (isset($_GET["coord_x"], $_GET["coord_y"], $_GET["radius"]) && validateNumbers()) {

		            $coord_x = $_GET["coord_x"];
		            $coord_y = $_GET["coord_y"];
		            $radius = $_GET["radius"];

		            $currentRequestId = $_SESSION["requestsCount"];

		            $_SESSION[$currentRequestId."coord_x"] = $coord_x;
		            $_SESSION[$currentRequestId."coord_y"] = $coord_y;
		            $_SESSION[$currentRequestId."radius"] = $radius;
		            $_SESSION[$currentRequestId."result"] = checkPosition($coord_x, $coord_y, $radius) ? "true" : "false";
		            $_SESSION[$currentRequestId."time"] = date("d/m/Y h:i:s a", time());

		            extendTable($_SESSION["requestsCount"]);

		            $_SESSION["requestsCount"]++;
		        }
		        ?>
		        </table>
		        <button id="back" onclick="window.location.href = '/';" value="w3docs">
		            Back
		        </button>
		    </div>
		</div>

	    
	</body>
</html>