<?php
namespace Mneuhaus\Expose\Utility;

/*
 * This file belongs to the package "mneuhaus/expose".
 * See LICENSE.txt that was shipped with this package.
 */

/**
 */
class StringFormatter {

	public static function formNameToPath($formName) {
		$parts = explode('[', $formName);
		array_walk($parts, function(&$value, $key){
			$value = trim($value, ']');
		});
		return implode('.', $parts);
	}

	public static function pathToFormId($path) {
		return str_replace('.', '-', $path);
	}

	public static function pathToTranslationId($path) {
		return preg_replace('/\.[0-9]*\./', '.', $path);
	}
}
?>