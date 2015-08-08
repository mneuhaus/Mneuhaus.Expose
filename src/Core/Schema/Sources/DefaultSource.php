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

use Flowpack\Expose\Core\Sources\AbstractSchemaSource;
use Flowpack\Expose\Utility\Inflector;
use TYPO3\Flow\Annotations as Flow;

/**
 */
class DefaultSource extends AbstractSchemaSource {

	/**
	 * @var Inflector
	 * @Flow\Inject
	 */
	protected $inflector;


	public function compileSchema() {
		$schema = array(
			'listProperties' => array('__toString'),
			'listBehaviors' => array(
				'\Flowpack\Expose\QueryBehaviors\SearchBehavior' => TRUE,
				'\Flowpack\Expose\QueryBehaviors\FilterBehavior' => TRUE,
				'\Flowpack\Expose\QueryBehaviors\PaginationBehavior' => TRUE,
				'\Flowpack\Expose\QueryBehaviors\SortBehavior' => TRUE
			),
			'defaultSortBy' => NULL,
			'defaultOrder' => NULL,
			'filterProperties' => array(),
			'searchProperties' => array()
		);
		$propertyNames = array_keys(get_class_vars($this->className));
		foreach ($propertyNames as $key => $propertyName) {
			if ($this->propertyShouldBeIgnored($propertyName) === TRUE) {
				continue;
			}
			$schema['properties'][$propertyName] = array(
				'name' => $propertyName,
				'label' => $propertyName,
				'parentClassName' => $this->className,
				'position' => ( $key + 1 ) * 100,
				'infotext' => '',
				'optionsProvider' => array(
					'Name' => 'Relation'
				)
			);
		}
		return $schema;
	}

}