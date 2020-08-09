<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @file
 */

namespace MediaWiki\Extension\ResponsibleVectorTwo;

use Skin;
use OutputPage;
use SkinVector;
use Vector\SkinVersionLookup;
use MediaWiki\MediaWikiServices;
use MediaWiki\Hook\BeforePageDisplayHook;

class Hooks implements BeforePageDisplayHook {

	/**
	 * Handler for the BeforePageDisplay hook
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 * @param OutputPage $out
	 * @param Skin $skin
	 */
	public function onBeforePageDisplay( $out, $skin ) : void {
		if ( !$skin instanceof SkinVector ) {
			return;
		}

		$skinVersionLookup = new SkinVersionLookup(
			$out->getRequest(), $skin->getUser(), $out->getConfig()
		);

		// legacy vector has its own responsible mode, use that instead
		if ( $skinVersionLookup->isLegacy() ) {
			return;
		}

		$out->addBodyClasses( 'skin-vector-two-responsible' );
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1' );

		$out->addModuleStyles( 'ext.responsibleVectorTwo.styles' );
	}
}
