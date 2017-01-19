<?
################################################################################
################################################################################
###                                                                          ### 
###						ARQUIVO PHP DE FUN��ES DE DATA v1.0					 ###
###                                                                          ### 
################################################################################
################################################################################

##############################
#
#   fun��o bd2human
#   Converte a data de Banco de dados para humano
#   $date = variavel com a data a ser analisada [formato 0000-00-00]
#
##############################

function bd2human($date) {
	$time = "";
	//verificando se alem da data foi dado o tempo tamb�m
	if (strlen($date) == 19) {
		$date = explode(" ", $date);
		$time = " ".substr($date[1], 0, 5);
		$date = $date[0];
	}
	$date = explode("-", $date);
	$date = $date[2]."/".$date[1]."/".$date[0];
	return $date.$time;
}

##############################
#
#   fun��o human2bd
#   Converte a data de humano para Banco de dados
#   $date = variavel com a data a ser analisada [formato 00/00/0000]
#
##############################

function human2bd($date) {
	$date = explode("/", $date);
	$date = $date[2]."-".$date[1]."-".$date[0];
	return $date;
}

##############################
#
#   fun��o hourexists
#   Verifica o hor�rio digitado realmente existe
#   $hour = variavel com a data a ser analisada [formato 00:00]
#   $mask = H para 0 - 23, h para 0 a 12
#
##############################

function hourexists($hour, $h = "H") {
	$hour = explode(":", $hour);
	$ok = true;
	
	if ($h == "H") { $h = 23; }
	elseif ($h == "h") { $h = 12; }
	
	if ($hour[0] > $h OR $hour[0] < 0) { $ok = false; }
	if ($hour[1] > 59 OR $hour[1] < 0) { $ok = false; }
	
	return $ok;
}

##############################
#
#   fun��o dateexists
#   Verifica se a data realmente existe
#   $date = variavel com a data a ser analisada [formato 0000-00-00]
#
##############################

function dateexists($date) {
	if (strpos($date, "/")) {
		$date = human2bd($date);
	}
	
	$date = explode("-", $date); //[0] ano; [1] mes; [2] dia;
	$datevalid = true;

	if ($date[1] == 0 OR $date[2] == 0) { $datevalid = false; }
	elseif ($date[1] == 1 AND $date[2] > 31)  { $datevalid = false; }
	elseif ($date[1] == 2) { //calculo do bissexto
		$bissexto = $date[0] % 4;
		if ($bissexto == 0)  {
			if ($date[2] > 29) { $datevalid = false; } //� bissexto
		}

		else {
			if ($date[2] > 28) { $datevalid = false; }
		}
	}
  
	elseif ($date[1] == 3 AND $date[2] > 31)  { $datevalid = false; }
	elseif ($date[1] == 4 AND $date[2] > 30)  { $datevalid = false; }
	elseif ($date[1] == 5 AND $date[2] > 31)  { $datevalid = false; }
	elseif ($date[1] == 6 AND $date[2] > 30)  { $datevalid = false; }
	elseif ($date[1] == 7 AND $date[2] > 31)  { $datevalid = false; }
	elseif ($date[1] == 8 AND $date[2] > 31)  { $datevalid = false; }
	elseif ($date[1] == 9 AND $date[2] > 30)  { $datevalid = false; }
	elseif ($date[1] == 10 AND $date[2] > 31) { $datevalid = false; }
	elseif ($date[1] == 11 AND $date[2] > 30) { $datevalid = false; }
	elseif ($date[1] == 12 AND $date[2] > 31) { $datevalid = false; }
	return $datevalid;
}

######################################################################
#
#   Nome: ifnotpassed (Se n�o passou)
#   Descri��o: Escreve o valor inserido se a data n�o tiver passado
#   $time > analisa se esse dia j� passou
#   $string > se o dia N�o tiver passado, retorna esse valor
#
######################################################################

function ifnotpassed($time, $string="")
{
	if (strpos($time, "/")) {
		$time = human2bd($time);
	}
	
	$time = explode("-", $time);
    $d = $time[2];
    $m = $time[1];
    $y = $time[0];

    if ((date("d") <= $d AND date("m") == $m AND date("Y") == $y) OR (date("m") < $m AND date("Y") == $y) OR (date("Y") < $y))
    {
		if ($string != "") {
			return $string; //retorna o valor pedido pelo programador
		}

		else {
			return true;
		}
    }
	
	else {
		return false;
	}
}

######################################################################
#
#   Nome: nextday (Pr�ximo dia)
#   Descri��o: Descobre que dia ser� amanh�
#   $data > o dia
#   $dias > quantos dias a frente desse dia voc� quer saber qual �
#   $format > formato do retorno
#
######################################################################

function nextday($data, $dias=1, $format = "d/m/Y") {
	if (strpos($data, "/")) {
		$data = human2bd($data);
	}
	$novadata = explode("-",$data);
	$dia = $novadata[2];
	$mes = $novadata[1];
	$ano = $novadata[0];
	
	return date($format, mktime(0, 0, 0, $mes, $dia + $dias, $ano));
}

######################################################################
#
#   Nome: numbtomonth (N�mero para m�s)
#   Descri��o: converte um n�mero de 1 � 12 no nome de um m�s
#   $M > N�mero do m�s
#
######################################################################

function numbtomonth($M)
{
  if      ($M == 1)  { $M = "janeiro"; }
  else if ($M == 2)  { $M = "fevereiro"; }
  else if ($M == 3)  { $M = "mar�o"; }
  else if ($M == 4)  { $M = "abril"; }
  else if ($M == 5)  { $M = "maio"; }
  else if ($M == 6)  { $M = "junho"; }
  else if ($M == 7)  { $M = "julho"; }
  else if ($M == 8)  { $M = "agosto"; }
  else if ($M == 9)  { $M = "setembro"; }
  else if ($M == 10) { $M = "outubro"; }
  else if ($M == 11) { $M = "novembro"; }
  else if ($M == 12) { $M = "dezembro"; }
  return $M;
}

#######################################
#  
#  Nome: getday
#  Descri��o: retorna o valor do dia de uma data no formato 0000-00-00 ou 00/00/0000
#
#  $date > data a ter o dia pego
#  
#######################################
function getday($date) {
	if (strpos($date, "/")) {
		$date = human2bd($date);
	}
	
	$date = explode("-", $date);
	return $date[2];
}

#######################################
#  
#  Nome: getmonth
#  Descri��o: retorna o valor do m�s de uma data no formato 0000-00-00 ou 00/00/0000
#
#  $date > data a ter o m�s pego
#  
#######################################
function getmonth($date) {
	if (strpos($date, "/")) {
		$date = human2bd($date);
	}
	
	$date = explode("-", $date);
	return $date[1];
}

#######################################
#  
#  Nome: getyear
#  Descri��o: retorna o valor do ano de uma data no formato 0000-00-00 ou 00/00/0000
#
#  $date > data a ter o ano pego
#  
#######################################
function getyear($date) {
	if (strpos($date, "/")) {
		$date = human2bd($date);
	}
	
	$date = explode("-", $date);
	return $date[0];
}

###########################################
#
#  Nome: diffDate
#  Descri��o: verifica quanto tempo h� entre uma data e outra,
#  respondendo o tempo em dias, semanas, meses ou anos arredondados
#
#  $date1 > primeira data, no formato 00/00/0000 ou 0000-00-00
#  $date2 > segunda data, no formato 00/00/0000 ou 0000-00-00
#  $type > fomato em que a resposta deve vir: D = Dia, S ou W = Semana, M = M�s e A ou Y = Ano.
#
###########################################

function diffDate($date1, $date2, $type="D") {
	if (strpos($date1, "/")) {
		$date1 = human2bd($date1);
	}
	
	if (strpos($date2, "/")) {
		$date2 = human2bd($date2);
	}
	
	$day1 = getday($date1);
	$day2 = getday($date2);
	$mouth1 = getmonth($date1);
	$mouth2 = getmonth($date2);
	$year1 = getyear($date1);
	$year2 = getyear($date2);
	
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);
	
	$diff = $date2 - $date1;
	
	// Calcula a diferen�a de dias
	$dias = (int)floor( $diff / (60 * 60 * 24));
	
	if ($type == "D") {
		$dias = $dias;
	}
	
	elseif ($type == "S" OR $type == "W") {
		$dias = $dias / 7;
	}
	
	elseif ($type == "M") {
		$year = $year2 - $year1;
		$mouth = $mouth2 - $mouth1;
		$dias = $mouth + ($year*12);
	}
	
	elseif ($type == "A" OR $type == "Y") {
		$dias = $year2 - $year1;
	}
	
	return floor($dias);
}

######################################################################
#
#   Nome: ITLDFM Is The Last Day From Month? (� o ultimo dia do m�s?)
#   Descri��o: Descobre se o dia da data � o ultimo no m�s, retornando true false
#   
#   $date > a date recebida no formato 00/00/0000 ou 0000-00-00
#
######################################################################

function ITLDFM($date) {
	if (
		(getmonth($date) == 1 AND getday($date) == 31) OR
		(getmonth($date) == 2 AND getday($date) == 28) AND ((getyear($date)%4) != 0) OR 
		(getmonth($date) == 2 AND getday($date) == 29) AND ((getyear($date)%4) == 0) OR 
		(getmonth($date) == 3 AND getday($date) == 31) OR 
		(getmonth($date) == 4 AND getday($date) == 30) OR 
		(getmonth($date) == 5 AND getday($date) == 31) OR 
		(getmonth($date) == 6 AND getday($date) == 30) OR 
		(getmonth($date) == 7 AND getday($date) == 31) OR 
		(getmonth($date) == 8 AND getday($date) == 31) OR 
		(getmonth($date) == 9 AND getday($date) == 30) OR 
		(getmonth($date) == 10 AND getday($date) == 31) OR 
		(getmonth($date) == 11 AND getday($date) == 30) OR 
		(getmonth($date) == 12 AND getday($date) == 31)
	) {
		return true;
	}
	
	else {
		return false;
	}
}

######################################################################
#
#   Nome: feriado()
#   Descri��o: Mostra todos os feriados do anos, incluindo os que s�o baseados na p�scoa
#   
#   $ano > o ano a retornar os feriados
#	$justpascoa > mostra apenas os feriados que s�o baseados na pascoa
#
######################################################################

function feriados($ano = null) {
	if ($ano === null) {
		$ano = intval(date('Y'));
	}

	$pascoa     = easter_date($ano); // Limite de 1970 ou ap�s 2037 da easter_date PHP consulta http://www.php.net/manual/pt_BR/function.easter-date.php
	$dia_pascoa = date('j', $pascoa);
	$mes_pascoa = date('n', $pascoa);
	$ano_pascoa = date('Y', $pascoa);

	$feriados = array(
		// Tatas Fixas dos feriados Nacionail Basileiras
		/* 0 */ mktime(0, 0, 0, 1,  1,   $ano), // (01/01) Confraterniza��o Universal - Lei n� 662, de 06/04/49
		/* 1 */ mktime(0, 0, 0, 4,  21,  $ano), // (21/04) Tiradentes - Lei n� 662, de 06/04/49
		/* 2 */ mktime(0, 0, 0, 5,  1,   $ano), // (01/05) Dia do Trabalhador - Lei n� 662, de 06/04/49
		/* 3 */ mktime(0, 0, 0, 9,  7,   $ano), // (07/09) Dia da Independ�ncia - Lei n� 662, de 06/04/49
		/* 4 */ mktime(0, 0, 0, 10,  12, $ano), // (12/10) N. S. Aparecida - Lei n� 6802, de 30/06/80
		/* 5 */ mktime(0, 0, 0, 11,  2,  $ano), // (02/11) Todos os santos - Lei n� 662, de 06/04/49
		/* 6 */ mktime(0, 0, 0, 11, 15,  $ano), // (15/11) Proclama��o da republica - Lei n� 662, de 06/04/49
		/* 7 */ mktime(0, 0, 0, 12, 25,  $ano), // (25/12) Natal - Lei n� 662, de 06/04/4
		
		// These days have a date depending on easter
		/* 8 */ mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa), //2�feria Carnaval
		/* 9 */ mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa), //3�feria Carnaval	
		/* 10 */ mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa), //6�feira Santa  
		/* 11 */ mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa), //Pascoa
		/* 12 */ mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa), //Corpus Cirist
	);

	sort($feriados);
	return $feriados;
}
?>