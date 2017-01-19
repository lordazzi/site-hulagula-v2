<?
################################################################################
################################################################################
###                                                                          ### 
###					ARQUIVO PHP DE FUN«’ES PARA FORMULЅRIOS					 ###
### 		(EDI«√O DE PLAVARAS, NЏMERO E VALIDA«√O DE FORMULЅRIOS) v1.0 	 ###
###                                                                          ### 
################################################################################
################################################################################

##############################
#
#   funзгo unacenta
#   Retira todos os acentos de uma palavra
#   $palavra = palavra a ter os acentos retirados
#
##############################

function unacenta($palavra) {
	str_replace("¬", "A", $palavra);
	str_replace("√", "A", $palavra);
	str_replace("Ѕ", "A", $palavra);
	str_replace("ј", "A", $palavra);
	str_replace("ƒ", "A", $palavra);
	str_replace("в", "a", $palavra);
	str_replace("г", "a", $palavra);
	str_replace("б", "a", $palavra);
	str_replace("а", "a", $palavra);
	str_replace("д", "a", $palavra);
	str_replace("@", "a", $palavra);
	str_replace(" ", "E", $palavra);
	str_replace("…", "E", $palavra);
	str_replace("»", "E", $palavra);
	str_replace("Ћ", "E", $palavra);
	str_replace("к", "e", $palavra);
	str_replace("й", "e", $palavra);
	str_replace("а", "e", $palavra);
	str_replace("л", "e", $palavra);
	str_replace("ќ", "I", $palavra);
	str_replace("Ќ", "I", $palavra);
	str_replace("ћ", "I", $palavra);
	str_replace("ѕ", "I", $palavra);
	str_replace("о", "i", $palavra);
	str_replace("н", "i", $palavra);
	str_replace("м", "i", $palavra);
	str_replace("п", "i", $palavra);
	str_replace("‘", "O", $palavra);
	str_replace("’", "O", $palavra);
	str_replace("”", "O", $palavra);
	str_replace("“", "O", $palavra);
	str_replace("÷", "O", $palavra);
	str_replace("ф", "o", $palavra);
	str_replace("х", "o", $palavra);
	str_replace("у", "o", $palavra);
	str_replace("т", "o", $palavra);
	str_replace("ц", "o", $palavra);
	str_replace("џ", "U", $palavra);
	str_replace("Џ", "U", $palavra);
	str_replace("ў", "U", $palavra);
	str_replace("№", "U", $palavra);
	str_replace("ы", "u", $palavra);
	str_replace("ъ", "u", $palavra);
	str_replace("щ", "u", $palavra);
	str_replace("ь", "u", $palavra);
	str_replace("«", "C", $palavra);
	str_replace("з", "c", $palavra);
	str_replace("—", "N", $palavra);
	str_replace("с", "n", $palavra);
	return $palavra;
}

##############################
#
#   funзгo domoney
#   Converte nъmeros decimais ou inteiros para o formato 0.00 (duas casas depois da vнrgula)
#   $date = variavel a ser alterada
#
##############################

function domoney($valor) {
	$valor = str_replace("R", "", $valor);
	$valor = str_replace("U", "", $valor);
	$valor = str_replace("S", "", $valor);
	$valor = str_replace("$", "", $valor);
	$valor = str_replace(" ", "", $valor);
	$valor = str_replace(",", ".", $valor);
	if (onlynumbers($valor, ".")) {//sу pode ter nъmeros e ponto se nгo retorna o mesmo valor
		$ponto = strpos($valor, ".");
		if ($ponto === 0 OR $ponto) { //se ponto existe ou й exatamente igual a zero (por que nesse caso 0 nгo й false, mas o primeiro valor da casa de uma string)
			$decimal = substr($valor, $ponto, 3);
			$valor = substr($valor, 0, $ponto);
			if ($ponto === 0) {
				$valor = "0".$valor;
			}
			
			if (strlen($decimal) == 2) {
				$decimal .= "0";
			}
			
			elseif (strlen($decimal) == 1) {
				$decimal .= "00";
			}
			
			return $valor.$decimal;
		}
		
		else {
			return $valor.".00";
		}
	}
	
	else {
		return $valor; //se o valor inserido tiver alguma coisa alйm de nъmeros e o ponto, entгo a funзгo retorna o prуprio valor em si.
	}
}

##############################
#
#   funзгo ajeita
#   Essa funзгo ajeita os nomes enviados para o banco de dados que forem escritos todos em maiusculas ou minusculas para o formato de primeira letra maiuscula e o resto minuscula, com exceзгo de preposiзхes
#
#   $nome = o nome a ser ajeitado
#
##############################

function ajeita($nome) {
	//deixa tudo em minuscula
	$nome = lower_acento($nome);
	$nome = strtolower($nome);
	
	//divide os nomes em arrays
	$nome = explode(" ", $nome);
	
	//deixando a primeira letra maiuscula das palavras que tenham mais de 3 letras
	$RunFor = count($nome); //nъmero de vezes que o for irб rodar
	$final_nome = "";
	for ($IntFor = 0; $IntFor < $RunFor; $IntFor++) {
		if ($nome[$IntFor] == "de" OR $nome[$IntFor] == "la" OR $nome[$IntFor] == "el" OR $nome[$IntFor] == "dos" OR $nome[$IntFor] == "da" OR $nome[$IntFor] == "das" OR $nome[$IntFor] == "do" OR $nome[$IntFor] == "com" OR $nome[$IntFor] == "e" OR $nome[$IntFor] == "na" OR $nome[$IntFor] == "no" OR $nome[$IntFor] == "nas" OR $nome[$IntFor] == "nos" OR $nome[$IntFor] == "аs" OR $nome[$IntFor] == "a" OR $nome[$IntFor] == "e" OR $nome[$IntFor] == "o" OR $nome[$IntFor] == "ou" OR $nome[$IntFor] == "pra" OR $nome[$IntFor] == "para" OR $nome[$IntFor] == "pras" OR $nome[$IntFor] == "pra" OR $nome[$IntFor] == "y") {
		}
		
		else {
			$nome[$IntFor] = ucfirst($nome[$IntFor]);
			if ($nome[$IntFor] == "Sao") { //corrigindo a mania feia de nгo colocar o tio no 'Sгo' dos nomes das cidades
				$nome[$IntFor] = "Sгo";
			}
			
			elseif ($nome[$IntFor] == "Joao") { 
				$nome[$IntFor] = "Joгo";
			}
		}
	}
	$nome = implode(" ", $nome);
	return $nome;
}

##############################
#
#   funзгo mail_valid
#   verifica se o email colocado й valido, retorna em true ou false (Email vбlido: verdadeiro? Email vбlido: falso?)
#
#   $email = o email a ser analisado
#
##############################

function mail_valid($mail) {
	$valido = true;
	
	if (strpos($mail, "@") == -1) {// tem arroba?
		$valido = false;
	}
	
	if (strpos($mail, ".com") == -1) {//tem .com
		$valido = false;
	}
	
	if (!strtolower($mail)) { //somente letras
		$valido = false;
	}
	
	if (!onlyletters($mail, "0123456789_-@.")) { //somente letras e nъmero
		$valido = false;
	}
	
	return $valido;
}

##############################
#
#   funзгo onlynumbers
#   verifica se uma string tem somente nъmeros, retorna em true ou false (apenas nъmero: verdadeiro? apenas letras: falso?)
#
#   $string = variavel a ser analisada
#	$addvalues = valores adicionais a serem aceitos
#
##############################

function onlynumbers($string, $addvalues = "") {
  $valid = true;
  for ($IntFor = 0; $IntFor < strlen($string); $IntFor++)
  {
    $char = lower_acento($string[$IntFor]);
    $rightchar = false;

        if ($char == "0") { $rightchar = true; }	elseif ($char == "1") { $rightchar = true; }
    elseif ($char == "2") { $rightchar = true; }	elseif ($char == "3") { $rightchar = true; }
    elseif ($char == "4") { $rightchar = true; }	elseif ($char == "5") { $rightchar = true; }
    elseif ($char == "6") { $rightchar = true; }	elseif ($char == "7") { $rightchar = true; }
    elseif ($char == "8") { $rightchar = true; }	elseif ($char == "9") { $rightchar = true; }
	
	if (strlen($addvalues) != "") //se nгo tiver nada na variavel de valores adicionais
	{
	  for ($IntFor2 = 0; $IntFor2 < strlen($addvalues); $IntFor2++)
	  {
	    $lowed = strtolower($addvalues[$IntFor2]);
		$lowed = lower_acento($lowed);
	    if ($char == $lowed) { $rightchar = true; }
	  }
	}
	
	if ($rightchar == false) { $valid = false; } //se ele nгo achou nenhuma das caracteres acima, o barato й invalido (caracteres especiais, letras etc.)
  }
 
  return $valid;
}

##############################
#
#   funзгo onlyletters
#   verifica se uma string tem somente letras ou espaзo, retorna em true ou false (apenas letras: verdadeiro? apenas letras: falso?)
#
#   $string = variavel a ser analisada
#	$addvalues = valores adicionais a serem aceitos
#
##############################

function onlyletters($string, $addvalues = "") {
  $valid = true;
  for ($IntFor = 0; $IntFor < strlen($string); $IntFor++)
  {
    $char = lower_acento($string[$IntFor]);
    $rightchar = false;

        if ($char == "a") { $rightchar = true; }	elseif ($char == "b") { $rightchar = true; }
    elseif ($char == "c") { $rightchar = true; }	elseif ($char == "d") { $rightchar = true; }
    elseif ($char == "e") { $rightchar = true; }	elseif ($char == "f") { $rightchar = true; }
    elseif ($char == "g") { $rightchar = true; }	elseif ($char == "h") { $rightchar = true; }
    elseif ($char == "i") { $rightchar = true; }	elseif ($char == "j") { $rightchar = true; }
    elseif ($char == "k") { $rightchar = true; }	elseif ($char == "l") { $rightchar = true; }
    elseif ($char == "m") { $rightchar = true; }	elseif ($char == "n") { $rightchar = true; }
    elseif ($char == "o") { $rightchar = true; }	elseif ($char == "p") { $rightchar = true; }
    elseif ($char == "q") { $rightchar = true; }	elseif ($char == "r") { $rightchar = true; }
    elseif ($char == "s") { $rightchar = true; }	elseif ($char == "t") { $rightchar = true; }
    elseif ($char == "u") { $rightchar = true; }	elseif ($char == "v") { $rightchar = true; }
    elseif ($char == "w") { $rightchar = true; }	elseif ($char == "x") { $rightchar = true; }
    elseif ($char == "y") { $rightchar = true; }	elseif ($char == "z") { $rightchar = true; }
	elseif ($char == " ") { $rightchar = true; }
	
	if (strlen($addvalues) != "") //se nгo tiver nada na variavel de valores adicionais
	{
	  for ($IntFor2 = 0; $IntFor2 < strlen($addvalues); $IntFor2++)
	  {
		$lowed = lower_acento($addvalues[$IntFor2]);
	    if ($char == $lowed) { $rightchar = true; }
	  }
	}
	
	if ($rightchar == false) { $valid = false; } //se ele nгo achou nenhuma das caracteres acima, o email й invalido (caracteres especiais, letras com acento etc.)
  }
 
  return $valid;
}

##############################
#
#   funзгo lower_acento
#   deixa todas as letras do termo em minusculas, incluindo acentos.
#
#   $term = a palavra a ter os acentos tornados em minusculas
#
##############################

function lower_acento($term) {
	$palavra = strtr(strtolower($term),"јЅ¬√ƒ≈∆«»… ЋћЌќѕ–—“”‘’÷„Ўў№Џёя","абвгдежзийклмнопрстуфхцчшщьъю€");
    return $palavra;
}

##############################
#
#   funзгo upper_acento
#   deixa todas as letras do termo em maiusculas, incluindo acentos.
#
#   $term = a palavra a ter os acentos tornados em maiusculas
#
##############################

function upper_acento($term) {
	$palavra = strtr(strtoupper($term),"абвгдежзийклмнопрстуфхцчшщьъю€","јЅ¬√ƒ≈∆«»… ЋћЌќѕ–—“”‘’÷„Ўў№Џёя");
	return $palavra;
}

##############################
#
#   funзгo isundermask (Estб debaixo da mascara?)
#   Verifica se o campo estб dentro da mascara que foi proposta.
#
#   $string = palavra a ser avaliada
#	$mask = mascara que ela deveria ter, 9 = nъmero, A ou a = letra, * = para qualquer coisa (se case sensitive estivar ativado, entгo A й apenas para letras maiusculas e a para minusculas)
#	$case = se as palavras devem ser tratadas com CASE SENSITIVE
#
##############################

function isundermask($string, $mask, $case = 1) {
	if (strlen($string) == strlen($mask)) {
		$isvalid = true; // predefine como valido
		for ($IntFor = 0; $IntFor < strlen($string); $IntFor++) {
			if ($case == 1)	{//se case sensitive estiver ativado
				$mask = lower_acento($mask);
				$string = lower_acento($string);
			}
			
			if ($mask[$IntFor] == "9") { //Somente nъmeros
				if (!onlynumbers($string[$IntFor])) { //Se nгo for um nъmero
					$isvalid = false;
				}
			}
			
			elseif ($mask[$IntFor] == "a") { //Somente letras minusculas
				if ($string[$IntFor] != lower_acento($string[$IntFor]) OR !onlyletters($string[$IntFor], "абвгдезийклмнопстуфхцщьъ")) { //se a letra nгo for igual a ela mesma em minuscula ou se ela nгo for uma letra
					$isvalid = false;
				}
			}
			
			elseif ($mask[$IntFor] == "A") { //Somente letras maiusculas
				if ($string[$IntFor] != upper_acento($string[$IntFor]) OR !onlyletters($string[$IntFor], "јЅ¬√ƒ≈«»… ЋћЌќѕ—“”‘’÷ў№Џ")) { //se a letra nгo for igual a ela mesma em maiuscula ou se ela nгo for uma letra
					$isvalid = false;
				}
			}
			
			elseif ($mask[$IntFor] == "*") { //Qualquer coisa
				
			}
			
			else { //Obrigatуriamente o item da mascara
				if ($mask[$IntFor] !== $string[$IntFor]) {
					$isvalid = false;
				}
			}
		}//final do for
		
		return $isvalid;
	}
	
	else {
		return false;
	}
}
?>