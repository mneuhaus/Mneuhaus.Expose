<?php
namespace Mneuhaus\Expose\Schema\Sources;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flowpack.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 */
abstract class AbstractSchemaSource implements SchemaSourceInterface {
	/**
	 * @var string
	 */
	protected $className;

	public function __construct($className) {
		$this->className = $className;
	}

	public function propertyShouldBeIgnored($propertyName) {
		#if ($this->reflectionService->isPropertyAnnotatedWith($this->className, $propertyName, 'TYPO3\Flow\Annotations\Transient')) {
		#	return TRUE;
		#}

		#if ($this->reflectionService->isPropertyAnnotatedWith($this->className, $propertyName, 'TYPO3\Flow\Annotations\Inject')) {
		#	return TRUE;
		#}

		return FALSE;
	}
}

?>