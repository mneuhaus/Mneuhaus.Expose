<?php
namespace Mneuhaus\Expose\Utility;

/*
 * This file belongs to the package "mneuhaus/expose".
 * See LICENSE.txt that was shipped with this package.
 */

/**
 * Inflector utilities for the Kickstarter. This is a basic conversion from PHP
 * class and field names to a human readable form.
 *
 */
class Inflector {

	/**
	 * @param string $word The word to pluralize
	 * @return string The pluralized word
	 */
	public function pluralize($word) {
		return \Sho_Inflect::pluralize($word);
	}

	/**
	 * Convert a model class name like "BlogAuthor" or a field name like
	 * "blogAuthor" to a humanized version like "Blog author" for better readability.
	 *
	 * @param string $camelCased The camel cased value
	 * @param boolean $lowercase Return lowercase value
	 * @return string The humanized value
	 */
	public function humanizeCamelCase($camelCased, $lowercase = FALSE) {
		$spacified = $this->spacify($camelCased);
		$result = strtolower($spacified);
		if (!$lowercase) {
			$result = ucfirst($result);
		}
		return $result;
	}

	/**
	 * Splits a string at lowercase/uppcase transitions and insert the glue
	 * character in between.
	 *
	 * @param string $camelCased
	 * @param string $glue
	 * @return string
	 */
	protected function spacify($camelCased, $glue = ' ') {
		return preg_replace('/([a-z0-9])([A-Z])/', '$1' . $glue . '$2', $camelCased);
	}
}
