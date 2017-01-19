<?php
/*  Não se preocupe! Esta é a única página do site que você verá PHP misturado com HTML! :D
  Te desejaria boa sorte na manutenção do site que eu desenvolvi, mas não precisa de sorte,
  meu código é simplesmente incrível -q
*/
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");
?>
    </head>
    <body>
    <?php
      $sql = new MySql();
      
      $config = $sql->Query("
        SELECT abre, fecha, naoabre
        FROM horario_extra
        WHERE data = '".date("Y-m-d")."';
      ");
      
      if (count($config) == 0) {
        $feriados = $sql->Query("
          SELECT
            idferiado, date_day, date_month,
            oneaster, easter_days
          FROM feriados
          WHERE consider = 1;
        ");
        
        $isFeriado = FALSE; $isVespera = FALSE;
        foreach ($feriados as $feriado) {
          if ($feriado["oneaster"] == 1) { // se o feriado é baseado na páscoa
            $pascoa = easter_date(date("Y"));
            
            $dia = date("d", $pascoa);
            $mes = date("m", $pascoa);
            $ano = date("Y", $pascoa);

            $holyday = date("Y-m-d", mktime(0, 0, 0, $mes, $dia + $feriado["easter_days"], $ano)); //  essa função vai dar erro em 2037 por causa do overflow no timestamp :D
            $vespera = date("Y-m-d", mktime(0, 0, 0, $mes, $dia + $feriado["easter_days"] - 1, $ano));
          } else { // se o feriado tem uma data fixa
            $holyday = date("Y-m-d", mktime(0, 0, 0, $feriado_array["date_month"], $feriado_array["date_day"], date("Y")));
            $vespera = date("Y-m-d", mktime(0, 0, 0, $feriado_array["date_month"], $feriado_array["date_day"] - 1, date("Y")));
          }
          
          if ($isFeriado == FALSE AND $holyday == date("Y-m-d")) {
            $isFeriado == TRUE;
          } else if ($isFeriado == FALSE AND $vespera == date("Y-m-d")) {
            $isVespera = TRUE;
          }
        }
        
        if ($isFeriado) {
          $code = 9;
        } else if ($isVespera) {
          $code = 8;
        } else {
          $code = date("w") + 1;
        }
        
        $config = $sql->Query("SELECT abre, fecha, naoabre FROM horario_extra WHERE semana = $code", TRUE);
      } else {
        $config = $config[0];
      }
      
      
      if ($config["naoabre"] == 1) {
        echo "<div class='close' id='openclose' title='Não abriremos hoje!'>Estamos fechados</div>";
      } else {
        $config["abre"] = explode(":", $config["abre"]);
        $config["fecha"] = explode(":", $config["fecha"]);
        
        $config["abre"] = ($config["abre"][0] * 60) + $config["abre"][1];
        $config["fecha"] = ($config["fecha"][0] * 60) + $config["fecha"][1];
        
        if (date("H") * 60 + date("i") >= $config["abre"] AND date("H") * 60 + date("i") <= $config["fecha"]) {
          echo "<div class='open' style='display:none' id='openclose'>Estamos abertos</div>";
        } else {
          echo "<div class='close' style='display:none' id='openclose'>Estamos fechados</div>";
        }
      }
      
    ?>
    <div id="container">
      <header id="main-header">
        <h1 class="logo">
          <img src="resource/img/logo.png" />
        </h1>
        <img src="resource/img/extra.png" style="position: absolute; z-index: 99;" />
        <div class="slider-wrapper theme-default" style="width: 656px; float: right; height: 200px;">
          <div id="slider" class="nivoSlider">
            <?php
              $folder = opendir("arquivo/foto_pizza/");
              while ($file = readdir($folder)) {
                if ($file != "." AND $file != ".." AND $file != "Thumbs.db") {
                  echo "<img src='arquivo/foto_pizza/$file' />";
                }
              }
            ?>
          </div>
        </div>
      </header>
      <section id="content">