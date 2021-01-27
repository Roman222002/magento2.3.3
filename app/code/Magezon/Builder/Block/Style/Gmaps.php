<?php
/**
 * Magezon
 *
 * This source file is subject to the Magezon Software License, which is available at https://www.magezon.com/license
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to https://www.magezon.com for more information.
 *
 * @category  Magezon
 * @package   Magezon_Builder
 * @copyright Copyright (C) 2019 Magezon (https://www.magezon.com)
 */

namespace Magezon\Builder\Block\Style;

class Gmaps extends \Magezon\Builder\Block\Style
{
	/**
	 * @return string
	 */
	public function getAdditionalStyleHtml()
	{
		$styleHtml = '';
		$element   = $this->getElement();

		$styles = [];
		$styles['width']  = $this->getStyleProperty($element->getData('map_width'));
		$styles['height'] = $this->getStyleProperty($element->getData('map_height'));
		$styleHtml .= $this->getStyles('#' . $element->getId() . '-map', $styles);

		$styles = [];
		$styles['color']      = $this->getStyleColor($element->getData('infobox_text_color'));
		$styles['background'] = $this->getStyleColor($element->getData('infobox_background_color'));
		$styles['width']      = $this->getStyleProperty($element->getData('infobox_width'));
		$styleHtml .= $this->getStyles('.gm-style-iw-c', $styles);

		$styles = [];
		$styles['background'] = $this->getStyleColor($element->getData('infobox_background_color'));
		$styleHtml .= $this->getStyles('.gm-style-iw-t::after', $styles);

		return $styleHtml;
	}
}