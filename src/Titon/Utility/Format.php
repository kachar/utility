<?php
/**
 * @copyright	Copyright 2010-2013, The Titon Project
 * @license		http://opensource.org/licenses/bsd-license.php
 * @link		http://titon.io
 */

namespace Titon\Utility;

use Titon\Utility\Time;
use Titon\Utility\Exception;
use \DateTime;

/**
 * Format provides utility methods for converting raw data to specific visual formats.
 */
class Format {

	/**
	 * Format a date string to an Atom feed format.
	 *
	 * @access public
	 * @param string|int $time
	 * @return string
	 * @static
	 */
	public static function atom($time) {
		return date(DateTime::ATOM, Time::toUnix($time));
	}

	/**
	 * Format a date string.
	 *
	 * @access public
	 * @param string|int $time
	 * @param string $format
	 * @return string
	 * @static
	 */
	public static function date($time, $format = '%Y-%m-%d') {
		return strftime($format, Time::toUnix($time));
	}

	/**
	 * Format a datetime string.
	 *
	 * @access public
	 * @param string|int $time
	 * @param string $format
	 * @return string
	 * @static
	 */
	public static function datetime($time, $format = '%Y-%m-%d %H:%M:%S') {
		return strftime($format, Time::toUnix($time));
	}

	/**
	 * Format a value to a certain string sequence. All #'s in the format will be replaced by the character in the same position within the sequence.
	 * All *'s will mask the character in the sequence. Large numbers should be passed as strings.
	 *
	 * {{{
	 * 		Format::format(1234567890, '(###) ###-####');				(123) 456-7890
	 * 		Format::format(1234567890123456, '****-****-####-####');	****-****-9012-3456
	 * }}}
	 *
	 * @access public
	 * @param int|string $value
	 * @param string $format
	 * @return mixed
	 * @static
	 */
	public static function format($value, $format) {
		$value = (string) $value;
		$length = mb_strlen($format);
		$result = $format;
		$pos = 0;

		for ($i = 0; $i < $length; $i++) {
			$char = $format[$i];

			if (($char === '#' || $char === '*') && isset($value[$pos])) {
				$replace = ($char === '*') ? '*' : $value[$pos];
				$result = substr_replace($result, $replace, $i, 1);
				$pos++;
			}
		}

		return $result;
	}

	/**
	 * Format a date string to an HTTP header format.
	 *
	 * @access public
	 * @param string|int $time
	 * @return string
	 * @static
	 */
	public static function http($time) {
		return gmdate('D, d M Y H:i:s T', Time::toUnix($time));
	}

	/**
	 * Format a phone number. A phone number can support multiple variations,
	 * depending on how many numbers are present.
	 *
	 * @access public
	 * @param int $value
	 * @param string $format
	 * @return string
	 * @static
	 */
	public static function phone($value, $format) {
		$value = preg_replace('/[^0-9]+/', '', $value);

		if (is_array($format)) {
			$length = mb_strlen($value);

			if ($length >= 11) {
				$format = $format[11];
			} else if ($length >= 10) {
				$format = $format[10];
			} else {
				$format = $format[7];
			}
		}

		return self::format($value, $format);
	}

	/**
	 * Format a timestamp as a date relative human readable string; also known as time ago in words.
	 *
	 * @access public
	 * @param string|int $time
	 * @return string
	 * @static
	 */
	public static function relativeTime($time) {
		// @todo
	}

	/**
	 * Format a date string to an RSS feed format.
	 *
	 * @access public
	 * @param string|int $time
	 * @return string
	 * @static
	 */
	public static function rss($time) {
		return date(DateTime::RSS, Time::toUnix($time));
	}

	/**
	 * Format a social security number.
	 *
	 * @access public
	 * @param string|int $value
	 * @param string $format
	 * @return string
	 * @static
	 */
	public static function ssn($value, $format) {
		return self::format($value, $format);
	}

	/**
	 * Format a time string.
	 *
	 * @access public
	 * @param string|int $time
	 * @param string $format
	 * @return string
	 * @static
	 */
	public static function time($time, $format = '%H:%M:%S') {
		return strftime($format, Time::toUnix($time));
	}

}