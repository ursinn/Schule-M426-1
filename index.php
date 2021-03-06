<!DOCTYPE html>
<html lang="de" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css">
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <title>Passwort Generieren</title>

    <script>
        $(document).ready(function(){
            $('.datenchange').click(function(){
                if($(this).css('background-color') == 'rgb(255, 0, 0)')
                    $(this).css('background-color', 'white');
                else
                    $(this).css('background-color', 'red');
            });
        });
  </script>
  </head>

  <body>
      <!-- Navigation / Titel -->
    <nav>
      <a href="#Home">PASSWORTKARTE</a>
    </nav>
    <!-- Hintergrund - Matrix -->
	<canvas id="c"></canvas>
    <div id="formular">
    <?php
        $beenden = 0;
    ?>
	<form class="" action="index.php" method="post">
		<p>Breite:<br><input type="number" name="bustaben" value="<?php if(isset($_POST['bustaben'])){echo $_POST['bustaben'];}else{echo '0';}?>"></p>
		<p>Höhe:<br><input type="number" name="zahlen" value="<?php if(isset($_POST['zahlen'])){echo $_POST['zahlen'];}else{echo '0';}?>"></p>
        <input type="submit" value="Tabelle Erstellen"/>
        <br>
        <br>
        <button onclick="drucken()">Drucken</button>
        <script type="text/javascript">
            // tabelle ausdrucken button
            function drucken() {
                window.print();
            }
        </script>
    </form>
    </div>
    <?php
    echo "<div id='tabelle' ";
    // kontrollieren ob überhaupt etwas eingegeben wurde
    if (isset($_POST['bustaben']) && isset($_POST['zahlen']) && !empty($_POST['bustaben']) && !empty($_POST['zahlen']) && $_POST['zahlen'] > 0 && $_POST['bustaben'] > 0) {
        // Eingaben in Variablen speichern
        $bu = $_POST['bustaben'];
        $za = $_POST['zahlen'];
        // wenn buchstaben oder zahlen mehr als 11 sind ist die tabelle scroll-bar
        if ($za>11 || $bu>11) {
            echo " style='overflow: scroll'";
        }
    }
    echo ">";
    ?>
	<table>
    <?php
    // kontrollieren ob überhaupt etwas eingegeben wurde
    if (isset($_POST['bustaben']) && isset($_POST['zahlen']) && !empty($_POST['bustaben']) && !empty($_POST['zahlen']) && $_POST['zahlen'] > 0 && $_POST['bustaben'] > 0) {
        // Eingaben in Variablen speichern
        $bu = $_POST['bustaben'];
        $za = $_POST['zahlen'];
        $zahlen = 1;
        $abc = 'A';
        // beginn der zellen der tabelle
        echo "<td class='big'></td>";
        for ($x = 1; $x <= $bu; $x++) {
            // Alphabet ausgeben
            echo "<td class='big'>" . $abc . "</td>";
            $abc++;
        }
        //Generiert Einen String
        function generateRandomString($length = 1)
        {
            // Zeichen in String speichern
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()-_=+[]{};:,.<>/?';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        //Berechnung der Anzahl
        $ausgaberand = $za * $bu;
        //Ausgabe der Tabelle
        echo "<tr>";
        echo "<td class='big'>" . $zahlen . "</td>";
        for ($i = 1; $i <= $ausgaberand; $i++) {
            // Zufälligen String ausgeben
            echo "<td class='datenchange'>" . generateRandomString() . "</td>";
            // Zahlen ausgeben
            if ($i == $bu || $i == $bu * $zahlen) {
                if ($za != $zahlen) {
                    $zahlen++;
                    echo "</tr>";
                    echo "<td class='big'>" . $zahlen . "</td>";
                }
            }
        }
    } else {
      // Fals nichts eingegeben wurde: Meldung ausgeben
      echo "<h2 style='color:white'>Bitte Geben Sie Höhe und Breite ein</h2>";
    }
    ?>
    </div>
    <footer>
        <li>Produkt Owner: Nicola Bühler</li>
        <li>Mitarbeiter: Joel Brendle</li>
        <li>Mitarbeiter: Ursin Filli</li>
    </footer>
</table>

<script>
// geting canvas by Boujjou Achraf
          var c = document.getElementById("c");
          var ctx = c.getContext("2d");

          //making the canvas full screen
          c.height = window.innerHeight;
          c.width = window.innerWidth;

          //chinese characters - taken from the unicode charset
          var matrix = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789@#$%^&*()*&^%+-/~{[|`]}";
          //converting the string into an array of single characters
          matrix = matrix.split("");

          var font_size = 10;
          var columns = c.width/font_size; //number of columns for the rain
          //an array of drops - one per column
          var drops = [];
          //x below is the x coordinate
          //1 = y co-ordinate of the drop(same for every drop initially)
          for(var x = 0; x < columns; x++)
              drops[x] = 1;

          //drawing the characters
          function draw()
          {
              //Black BG for the canvas
              //translucent BG to show trail
              ctx.fillStyle = "rgba(0, 0, 0, 0.04)";
              ctx.fillRect(0, 0, c.width, c.height);

              ctx.fillStyle = "#f4427d";//green text
              ctx.font = font_size + "px arial";
              //looping over drops
              for(var i = 0; i < drops.length; i++)
              {
                  //a random chinese character to print
                  var text = matrix[Math.floor(Math.random()*matrix.length)];
                  //x = i*font_size, y = value of drops[i]*font_size
                  ctx.fillText(text, i*font_size, drops[i]*font_size);

                  //sending the drop back to the top randomly after it has crossed the screen
                  //adding a randomness to the reset to make the drops scattered on the Y axis
                  if(drops[i]*font_size > c.height && Math.random() > 0.975)
                      drops[i] = 0;

                  //incrementing Y coordinate
                  drops[i]++;
              }
          }

          setInterval(draw, 35);

</script>
</body>
</html>
