<?php
namespace Mneuhaus\Expose\Utility;

/*
 * This file belongs to the package "mneuhaus/expose".
 * See LICENSE.txt that was shipped with this package.
 */

/**
 */
class StringRepresentation {
	public static function convert($mixed) {
		switch (true) {
			case is_string($mixed):
			case is_int($mixed):
			case is_float($mixed):
			case is_double($mixed):
			case is_null($mixed):
				return strval($mixed);

			case is_bool($mixed):
				return $mixed === TRUE ? 'true' : 'false';

			case is_resource($mixed):
				$type = get_resource_type($mixed);
				if ('stream' === $type) {
					$metaData = stream_get_meta_data($mixed);
					$info = ' ' . $metaData['mode'];
				} else {
					$info = '';
				}
				return sprintf('<resource: %s #%d%s>', $type, $mixed, $info);

			case $mixed instanceof \IteratorAggregate:
				$mixed = iterator_to_array($mixed);

			case is_array($mixed):
				foreach ($mixed as $key => $value) {
					$mixed[$key] = self::convert($value);
				}
				return implode(', ', $mixed);;

			case is_object($mixed) && method_exists($mixed, '__toString'):
				return $mixed->__toString();

			case is_object($mixed):
				$className = get_class($mixed);
				$parts = explode('\\', $className);
				return sprintf('<%s: %s>', end($parts), spl_object_hash($mixed));

			default:
				return 'Unknown type of variable';
				break;
		}
	}
}
?>