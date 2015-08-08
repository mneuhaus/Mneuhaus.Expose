<?php
namespace Mneuhaus\Expose\Schema;

use Mneuhaus\Expose\Schema\ClassSchema;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flowpack.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Render a Form section using the Form framework
 */
class ClassSchemaFactory {
	/**
	 * @var array
	 */
	protected $sources = array(
			'\Flowpack\Expose\Reflection\Sources\DefaultSource',
			// '\Flowpack\Expose\Reflection\Sources\PhpSource',
			// '\Flowpack\Expose\Reflection\Sources\YamlSource'
	);

	/**
	 * @param array $sources
	 */
	public function setSources($sources) {
		$this->sources = $sources;
	}

	/**
	 * @return array
	 */
	public function getSources() {
		return $this->sources;
	}

	public function create($className) {
		$schema = array(
			'properties' => array()
		);

		foreach ($this->getSources() as $key => $sourceClassName) {
			$source = new $sourceClassName($className);
			$schema = array_merge_recursive($schema, $source->compileSchema());
		}

#		$arraySorter = new PositionalArraySorter($schema['properties'], 'position');
#		try {
#			$schema['properties'] = $arraySorter->toArray();
#		} catch (InvalidPositionException $exception) {
#			throw new TypoScript\Exception('Invalid position string', 1345126502, $exception);
#		}

		$classSchema = new ClassSchema($schema);

		return $classSchema;
	}
}

?>