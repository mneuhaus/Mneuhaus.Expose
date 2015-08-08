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

use Flowpack\Expose\Reflection\ClassSchema;
use Flowpack\Expose\Utility\StringFormatter;

/**
 */
class PropertySchema {
	/**
	 * the class name to build the form for
	 *
	 * @var string
	 */
	protected $className;

	/**
	 * @var ClassSchema
	 */
	protected $classSchema;

	/**
	 * @var string
	 */
	protected $formName;

	/**
	 * @var array
	 */
	protected $schema;

	/**
	 * @var string
	 */
	protected $prefix;

	/**
	 *
	 * @param string $schema
	 * @param strign $prefix
	 * @return void
	 */
	public function __construct($schema, $classSchema = NULL, $prefix = NULL) {
		$this->schema = $schema;
		if ($classSchema !== NULL) {
			$this->className = $classSchema->getClassName();
			$this->classSchema = $classSchema;
		}
		$this->prefix = $prefix;
	}

	public function __toString() {
		return $this->getName();
	}

	public function getName() {
		return $this->schema['name'];
	}

	public function getPath() {
		return $this->prefix === NULL ? $this->schema['name'] : $this->prefix . '.' . $this->schema['name'];
	}

	public function getFormId() {
		return StringFormatter::pathToFormId($this->getPath());
	}

	public function getLabel() {
		return $this->schema['label'];
	}

	public function getPosition() {
		return $this->schema['@position'];
	}

	public function getInfotext() {
		return $this->schema['infotext'];
	}

	public function getType() {
		return $this->schema['type'];
	}

	public function getElementType() {
		return $this->schema['elementType'];
	}

	public function getControl() {
		return $this->schema['control'];
	}

	public function getHandler() {
		if (isset($this->schema['handler'])) {
			return $this->schema['handler'];
		}
		return NULL;
	}

	public function setControl($control) {
		$this->schema['control'] = $control;
	}

	public function getClassName() {
		return $this->className;
	}

	public function getClassSchema() {
		return $this->classSchema;
	}

	public function getTranslationId() {
		return StringFormatter::pathToTranslationId($this->getPath());
	}

	public function getOptionsProvider() {
		if (isset($this->schema['optionsProvider'])) {
			$settings = $this->schema['optionsProvider'];
			$className = $this->schema['optionsProvider']['Name'];
			if (!class_exists($className)) {
				$className = '\Flowpack\Expose\OptionsProvider\\' . $className . 'OptionsProvider';
			}
			return new $className($this, $settings);
		}
	}

	/**
	 * @param string $formName
	 */
	public function setFormName($formName) {
		$this->formName = $formName;
	}

	/**
	 * @return string
	 */
	public function getFormName() {
		return $this->formName;
	}
}

?>