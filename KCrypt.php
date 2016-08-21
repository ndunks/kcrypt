<?php
/**
* KCrypt 1.0 - 08/2016
* ASCII String compression with mapped dictionary.
*/
class KCrypt
{
	public static $DICT;
	private static $buff;
	const encryptable_limit = 126; //maximum ascii code for readable char
	const escape_char	= '%'; // 

	static function initialize(&$dictionary)
	{
		$index	= self::encryptable_limit;
		foreach ($dictionary as $key => $value){
			self::$DICT[  ++$index ] = $value;
			if( $index > 255)
				throw new Exception("Maximum index is 255", 1);
		}
	}

	static function unescape(&$data)
	{
		$pos	= 0;
		self::$buff = "";
		while ($pos < strlen($data))
		{
			if($data[$pos] == self::escape_char)
			{
				self::$buff .= @chr(hexdec( $data[++$pos] . $data[++$pos] ));
			}else
			{
				self::$buff .= $char;
			}
				$pos++;
		}
		return self::$buff;
	}

	static function escape(&$data)
	{
		self::$buff = "";
		foreach (str_split($data) as $c){
			$code	= ord($c);
			if($code > 255)
				throw new Exception("Unsupported char code", 1);
				
			if($code > self::encryptable_limit || $c == self::escape_char)
			{
				// escape high character
				self::$buff .= self::escape_char . base_convert($code, 10, 16);
			}else
			{
				self::$buff .= $c;
			}
		}
		return self::$buff;
	}

	static function encrypt($data)
	{
		self::$buff	= self::escape($data);

		foreach (self::$DICT as $key => &$dict)
		{
			if($key > 255) break;
			$pos	= 0;
			do {
				if( ($pos = strpos(self::$buff, $dict, $pos)) !== false )
					self::$buff	= substr_replace(self::$buff, chr($key), $pos, strlen($dict));
			} while ($pos !== false);
		}
		return self::$buff;
	}
	static function decrypt($data)
	{
		$pos		= 0;
		self::$buff = "";

		while ($pos < strlen($data))
		{
			$char	= $data[$pos];
			$code	= ord($char);
			if(isset(self::$DICT[$code]))
			{
				self::$buff .= self::$DICT[$code];
			}elseif($char == self::escape_char) // unescape here
			{
				self::$buff .= @chr(hexdec( $data[++$pos] . $data[++$pos] ));
			}else
			{
				self::$buff .= $char;
			}
			$pos++;
		}

		return self::$buff;
	}
}