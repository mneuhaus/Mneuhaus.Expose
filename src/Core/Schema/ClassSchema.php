<?php
namespace Mneuhaus\Expose\Schema;

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
class ClassSchema {

	/**
	 * the class name to build the form for
	 *
	 * @var string
	 */
	protected $className;

	/**
	 * @var array
	 */
	protected $schema;

	/**
	 * @var array
	 */
	protected $properties;

	/**
	 * @var string
	 */
	protected $propertyPrefix;

	/**
	 * @var object
	 */
	protected $object;

	/**
	 *
	 * @param string $className
	 * @param string $propertyPrefix
	 * @param string $scope
	 * @param object $object
	 * @param CacheManager $cacheManager
	 * @param ConfigurationManager $configurationManager
	 * @param ReflectionService $reflectionService
	 * @return void
	 */
	public function __construct($className, $classSchema, $propertyPrefix = NULL, $scope = NULL) {
		$this->className = '\\' . ltrim($className, '\\');
		$this->propertyPrefix = $propertyPrefix;

		// Todo reimplement caching!
		$this->schema = $classSchema;
		$this->properties = $this->schema['properties'];
	}

	public function setObject($object) {
		$this->object = $object;
	}

	public function getPropertyNames() {
		return array_keys($this->properties);
	}

	public function getProperties($properyNames = NULL) {
		if ($properyNames === NULL) {
			$properyNames = $this->getPropertyNames();
		}

		$properties = array();
		foreach ($properyNames as $propertyName) {
			if ($propertyName === '__toString') {
				$property = new PropertySchema(array(
					'name' => $propertyName,
					'label' => ''
				), $this, $this->propertyPrefix);
			} else {
				$property = $this->getProperty($propertyName);
			}
			$properties[$propertyName] = $property;
		}

		return $properties;
	}

	public function getClassName() {
		return $this->className;
	}

	public function getProperty($propertyName) {
		if (stristr($propertyName, '.')) {
			$parts = explode('.', $propertyName);
			$propertyPrefix = array_shift($parts);
			$property = new PropertySchema($this->properties[$propertyPrefix], $this, $this->propertyPrefix);

			if ($property->getElementType() !== NULL) {
				$propertyClassName = $property->getElementType();
				$propertyPrefix.= '.' . array_shift($parts);

			} else {
				$propertyClassName = $property->getType();
			}

			if (is_object($this->object)) {
				// TODO reimplement without flow!
				// $propertyValue = ObjectAccess::getPropertyPath($this->object, $propertyPrefix);
				// if (is_object($propertyValue)) {
				// 	$propertyClassName = $this->reflectionService->getClassNameByObject($propertyValue);
				// }
			}

			$propertyClassSchema = new ClassSchema($propertyClassName, $propertyPrefix);

			return $propertyClassSchema->getProperty(implode('.', $parts));
		}
		return new PropertySchema($this->properties[$propertyName], $this, $this->propertyPrefix);
	}

	public function getListPropertyNames() {
		return $this->schema['listProperties'];
	}

	public function getListProperties() {
		return $this->getProperties($this->getListPropertyNames());
	}

	public function getSearchPropertyNames() {
		return $this->schema['searchProperties'];
	}

	public function getSearchProperties() {
		return $this->getProperties($this->getSearchPropertyNames());
	}

	public function getFilterPropertNames() {
		return $this->schema['filterProperties'];
	}

	public function getFilterProperties() {
		return $this->getProperties($this->getFilterPropertNames());
	}

	public function getDefaultOrder() {
		return $this->schema['defaultOrder'];
	}

	public function getDefaultSortBy() {
		return $this->schema['defaultSortBy'];
	}

	public function getListBehaviors() {
		return $this->schema['listBehaviors'];
	}

	public function getFieldsets() {
		return array(
			array(
				'name' => '',
				'fields' => $this->getPropertyNames()
			)
		);
	}
}

?>