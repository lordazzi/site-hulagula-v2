<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 12/10/12 #

class System {
	public function saveCookie() {
		if (@$_COOKIE["ttots"] == FALSE) {
			if (!(@$_SESSION["ttots_cookie"] <> FALSE)) {
				$_SESSION["ttots_cookie"] = MD5(System::getIp(FALSE).date("YmdHis").rand(-250, 250));
			}
			setcookie("ttots", $_SESSION["ttots_cookie"]);
		}
		return @$_COOKIE["ttots"];
	}
	
	public function getCookie() {
		return @$_COOKIE["ttots"];
	}

	public function getComeFrom() {
		if (isSet($_SERVER["HTTP_REFERER"])) {
			return $_SERVER["HTTP_REFERER"];
		} else {
			return "";
		}
	}
	
	/** pega o IP do usu�rio e o IP interno (192.168.1.X) */
	public function getIp($full = TRUE) {
		if ($full == TRUE) { 
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				return $_SERVER['HTTP_CLIENT_IP'];
			}

			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}

			else {
				return $_SERVER['REMOTE_ADDR'];
			}
		} else {
			$ip = explode(", ", System::getIp());
			return $ip[count($ip) - 1];
		}
	}
	
	/** pega a string do browser que identifica o browser e sistema operacional */
	public function getBrowseString() {
		return $_SERVER["HTTP_USER_AGENT"];
	}
}
?>