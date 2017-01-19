<?
################################################################################
################################################################################
###                                                                          ### 
###					ARQUIVO PHP DE FUN��ES PARA FORMUL�RIOS					 ###
### 		(EDI��O DE PLAVARAS, N�MERO E VALIDA��O DE FORMUL�RIOS) v1.0 	 ###
###                                                                          ### 
################################################################################
################################################################################

##############################
#
#   fun��o unacenta
#   Retira todos os acentos de uma palavra
#   $palavra = palavra a ter os acentos retirados
#
##############################

function unacenta($palavra) {
	str_replace("�", "A", $palavra);
	str_replace("�", "A", $palavra);
	str_replace("�", "A", $palavra);
	str_replace("�", "A", $palavra);
	str_replace("�", "A", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("�", "a", $palavra);
	str_replace("@", "a", $palavra);
	str_replace("�", "E", $palavra);
	str_replace("�", "E", $palavra);
	str_replace("�", "E", $palavra);
	str_replace("�", "E", $palavra);
	str_replace("�", "e", $palavra);
	str_replace("�", "e", $palavra);
	str_replace("�", "e", $palavra);
	str_replace("�", "e", $palavra);
	str_replace("�", "I", $palavra);
	str_replace("�", "I", $palavra);
	str_replace("�", "I", $palavra);
	str_replace("�", "I", $palavra);
	str_replace("�", "i", $palavra);
	str_replace("�", "i", $palavra);
	str_replace("�", "i", $palavra);
	str_replace("�", "i", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "O", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "o", $palavra);
	str_replace("�", "U", $palavra);
	str_replace("�", "U", $palavra);
	str_replace("�", "U", $palavra);
	str_replace("�", "U", $palavra);
	str_replace("�", "u", $palavra);
	str_replace("�", "u", $palavra);
	str_replace("�", "u", $palavra);
	str_replace("�", "u", $palavra);
	str_replace("�", "C", $palavra);
	str_replace("�", "c", $palavra);
	str_replace("�", "N", $palavra);
	str_replace("�", "n", $palavra);
	return $palavra;
}

##############################
#
#   fun��o domoney
#   Converte n�meros decimais ou inteiros para o formato 0.00 (duas casas depois da v�rgula)
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
	if (onlynumbers($valor, ".")) {//s� pode ter n�meros e ponto se n�o retorna o mesmo valor
		$ponto = strpos($valor, ".");
		if ($ponto === 0 OR $ponto) { //se ponto existe ou � exatamente igual a zero (por que nesse caso 0 n�o � false, mas o primeiro valor da casa de uma string)
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
		return $valor; //se o valor inserido tiver alguma coisa al�m de n�meros e o ponto, ent�o a fun��o retorna o pr�prio valor em si.
	}
}

##############################
#
#   fun��o ajeita
#   Essa fun��o ajeita os nomes enviados para o banco de dados que forem escritos todos em maiusculas ou minusculas para o formato de primeira letra maiuscula e o resto minuscula, com exce��o de preposi��es
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
	$RunFor = count($nome); //n�mero de vezes que o for ir� rodar
	$final_nome = "";
	for ($IntFor = 0; $IntFor < $RunFor; $IntFor++) {
		if ($nome[$IntFor] == "de" OR $nome[$IntFor] == "la" OR $nome[$IntFor] == "el" OR $nome[$IntFor] == "dos" OR $nome[$IntFor] == "da" OR $nome[$IntFor] == "das" OR $nome[$IntFor] == "do" OR $nome[$IntFor] == "com" OR $nome[$IntFor] == "e" OR $nome[$IntFor] == "na" OR $nome[$IntFor] == "no" OR $nome[$IntFor] == "nas" OR $nome[$IntFor] == "nos" OR $nome[$IntFor] == "�s" OR $nome[$IntFor] == "a" OR $nome[$IntFor] == "e" OR $nome[$IntFor] == "o" OR $nome[$IntFor] == "ou" OR $nome[$IntFor] == "pra" OR $nome[$IntFor] == "para" OR $nome[$IntFor] == "pras" OR $nome[$IntFor] == "pra" OR $nome[$IntFor] == "y") {
		}
		
		else {
			$nome[$IntFor] = ucfirst($nome[$IntFor]);
			if ($nome[$IntFor] == "Sao") { //corrigindo a mania feia de n�o colocar o tio no 'S�o' dos nomes das cidades
				$nome[$IntFor] = "S�o";
			}
			
			elseif ($nome[$IntFor] == "Joao") { 
				$nome[$IntFor] = "Jo�o";
			}
		}
	}
	$nome = implode(" ", $nome);
	return $nome;
}

##############################
#
#   fun��o mail_valid
#   verifica se o email colocado � valido, retorna em true ou false (Email v�lido: verdadeiro? Email v�lido: falso?)
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
	
	if (!onlyletters($mail, "0123456789_-@.")) { //somente letras e n�mero
		$valido = false;
	}
	
	return $valido;
}

##############################
#
#   fun��o onlynumbers
#   verifica se uma string tem somente n�meros, retorna em true ou false (apenas n�mero: verdadeiro? apenas letras: falso?)
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
	
	if (strlen($addvalues) != "") //se n�o tiver nada na variavel de valores adicionais
	{
	  for ($IntFor2 = 0; $IntFor2 < strlen($addvalues); $IntFor2++)
	  {
	    $lowed = strtolower($addvalues[$IntFor2]);
		$lowed = lower_acento($lowed);
	    if ($char == $lowed) { $rightchar = true; }
	  }
	}
	
	if ($rightchar == false) { $valid = false; } //se ele n�o achou nenhuma das caracteres acima, o barato � invalido (caracteres especiais, letras etc.)
  }
 
  return $valid;
}

##############################
#
#   fun��o onlyletters
#   verifica se uma string tem somente letras ou espa�o, retorna em true ou false (apenas letras: verdadeiro? apenas letras: falso?)
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
	
	if (strlen($addvalues) != "") //se n�o tiver nada na variavel de valores adicionais
	{
	  for ($IntFor2 = 0; $IntFor2 < strlen($addvalues); $IntFor2++)
	  {
		$lowed = lower_acento($addvalues[$IntFor2]);
	    if ($char == $lowed) { $rightchar = true; }
	  }
	}
	
	if ($rightchar == false) { $valid = false; } //se ele n�o achou nenhuma das caracteres acima, o email � invalido (caracteres especiais, letras com acento etc.)
  }
 
  return $valid;
}

##############################
#
#   fun��o lower_acento
#   deixa todas as letras do termo em minusculas, incluindo acentos.
#
#   $term = a palavra a ter os acentos tornados em minusculas
#
##############################

function lower_acento($term) {
	$palavra = strtr(strtolower($term),"������������������������������","������������������������������");
    return $palavra;
}

##############################
#
#   fun��o upper_acento
#   deixa todas as letras do termo em maiusculas, incluindo acentos.
#
#   $term = a palavra a ter os acentos tornados em maiusculas
#
##############################

function upper_acento($term) {
	$palavra = strtr(strtoupper($term),"������������������������������","������������������������������");
	return $palavra;
}

##############################
#
#   fun��o isundermask (Est� debaixo da mascara?)
#   Verifica se o campo est� dentro da mascara que foi proposta.
#
#   $string = palavra a ser avaliada
#	$mask = mascara que ela deveria ter, 9 = n�mero, A ou a = letra, * = para qualquer coisa (se case sensitive estivar ativado, ent�o A � apenas para letras maiusculas e a para minusculas)
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
			
			if ($mask[$IntFor] == "9") { //Somente n�meros
				if (!onlynumbers($string[$IntFor])) { //Se n�o for um n�mero
					$isvalid = false;
				}
			}
			
			elseif ($mask[$IntFor] == "a") { //Somente letras minusculas
				if ($string[$IntFor] != lower_acento($string[$IntFor]) OR !onlyletters($string[$IntFor], "������������������������")) { //se a letra n�o for igual a ela mesma em minuscula ou se ela n�o for uma letra
					$isvalid = false;
				}
			}
			
			elseif ($mask[$IntFor] == "A") { //Somente letras maiusculas
				if ($string[$IntFor] != upper_acento($string[$IntFor]) OR !onlyletters($string[$IntFor], "������������������������")) { //se a letra n�o for igual a ela mesma em maiuscula ou se ela n�o for uma letra
					$isvalid = false;
				}
			}
			
			elseif ($mask[$IntFor] == "*") { //Qualquer coisa
				
			}
			
			else { //Obrigat�riamente o item da mascara
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