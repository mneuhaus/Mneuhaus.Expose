<?php
namespace Mneuhaus\Expose\Utility;

/*
 * This file belongs to the package "mneuhaus/expose".
 * See LICENSE.txt that was shipped with this package.
 */

use Mneuhaus\Expose\Exception;

/**
 */
class SettingsValidator {

	public static function validate($settings, $supportDefinitions) {
		// check for settings given but not supported
		if (($unsupportedSettings = array_diff_key($settings, $supportDefinitions)) !== array()) {
			$supportedSettings = array_keys($supportDefinitions);
			foreach (array_keys($unsupportedSettings) as $unsupportedSetting) {
				foreach ($supportedSettings as $supportedSetting) {
					$similarity = 0;
					similar_text($supportedSetting, $unsupportedSetting, $similarity);
					if ($similarity > 50) {
						throw new Exception(sprintf('The settings "%s" you\'re trying to set don\'t exist, did you mean: "%s" ?.', $unsupportedSetting, $supportedSetting), 1407785248);
					}
				}
			}
			throw new Exception(sprintf('The settings "%s" you\'re trying to set don\'t exist.', implode(',', array_keys($unsupportedSettings))), 1407785250);
		}

		// check for required settings being set
		array_walk(
			$supportDefinitions,
			function($supportedSettingData, $supportedSettingName, $settings) {
				if (isset($supportedSettingData['required']) && $supportedSettingData['required'] == TRUE && !array_key_exists($supportedSettingName, $settings)) {
					throw new Exception('Missing required setting: ' . $supportedSettingName . chr(10) . $supportedSettingData['description'], 1407785252);
				}
			},
			$settings
		);
	}
}
?>