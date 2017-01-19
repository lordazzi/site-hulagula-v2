			</div><!-- fechando a DIV content, aberta no menu -->
			<div id="footer">
				<b>Americo Samarone, 264 - Sacomã</b>
				<span>
					<span>2061.9139</span>
					<span>2274.7343</span>
					<span>2914.5757</span>
				</span>
			</div>
		</div>
		<? 
		//IDENTIFICANDO OS FERIADOS E AS VESPERAS
		$data = mysql_query("SELECT * FROM feriados");
		$is_vespera = false; $is_feriado = false;
		while ($feriado_array = mysql_fetch_array($data)) {
			//VERIFICANDO SE HOJE É UM FERIADO OU VESPERA DE FERIADO
			//É uma feriado na páscoa?
			if ($feriado_array["oneaster"] == 1) {
				$pascoa = easter_date(date("Y"));
				$dia_pascoa = date('j', $pascoa);
				$mes_pascoa = date('n', $pascoa);
				$ano_pascoa = date('Y', $pascoa);
				$pascoa = $ano_pascoa."-".$mes_pascoa."-".$dia_pascoa;
				
				$feria = nextday($pascoa, $feriado_array["easter_days"], "Y-m-d");
				$vesp = nextday($feria, -1, "Y-m-d");
				
				if ($is_feriado == false AND $feria == date("Y-m-d")) {
					$is_feriado == true;
				}
				
				elseif ($is_feriado == false AND $vesp == date("Y-m-d")) {
					$is_vespera = true;
				}
			}
			
			//É um feriado de data fixa
			else {
				//Se o dia ou o mês for menor ou igual a nova ele recebe um nove na frente para ser arredondado (de 2012-9-2 para 2012-09-02)
				if ($feriado_array["date_month"] <= 9) { $month = "0".$feriado_array["date_month"]; } else { $month = "0".$feriado_array["date_month"]; }
				if ($feriado_array["date_day"] <= 9) { $day = "0".$feriado_array["date_day"]; } else { $day = "0".$feriado_array["date_month"]; }
				$feria = date("Y")."-".$month."-".$day;
				$vesp = nextday($feria, -1, "Y-m-d");
				if ($is_feriado == false AND $feria == date("Y-m-d")) {
					$is_feriado == true;
				}
				
				elseif ($is_feriado == false AND $vesp == date("Y-m-d")) {
					$is_vespera = true;
				}
			}
		}
		
		//Verificando se é domingo, segunda, terça, quarta, quinta, sexta, sábado, véspera de feriado ou feriado.
		if ($is_feriado == true) {
			$code = 9;
		}
		
		elseif ($is_vespera == true) {
			$code = 8;
		}
		
		else {
			$code = date("w") + 1;
		}
		
		//VERIFICANDO SE ELE VAI USAR O CÓDIGO PARA IDENTIFICAR O HORÁRIO DE ABERTURA OU VAI SE BASEAR EM UM REGISTRO FEITO MANUALMENTE
		$data = mysql_query("SELECT * FROM horario_extra WHERE data='".date("Y-m-d")."'");
		if (@mysql_num_rows($data) != 0) {
			$semana = mysql_fetch_array($data);
		}
		
		else {
			$data = mysql_query("SELECT * FROM horario WHERE semana=$code");
			$semana = mysql_fetch_array($data);
		}
		
		if ($semana["naoabre"] == 1) {
			echo "<div class='close' id='openclose'>Estamos fechados</div>";
		}
		
		else {
			$abre = explode(":", $semana["abre"]);
			$fecha = explode(":", $semana["fecha"]);
			if (mktime(date("H"), date("i"), 0, 0, 0, 0) >= mktime($abre[0], $abre[1], 0, 0, 0, 0) AND mktime(date("H"), date("i"), 0, 0, 0, 0) <= mktime($fecha[0], $fecha[1], 0, 0, 0, 0)) {
				echo "<div class='open' id='openclose'>Estamos abertos</div>";
			}
			
			else {
				echo "<div class='close' id='openclose'>Estamos fechados</div>";
			}
		}
		
		?>
	</body>
</html>