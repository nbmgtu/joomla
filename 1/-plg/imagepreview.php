<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgContentImagepreview extends JPlugin
{
	function plgContentImagepreview( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	function onPrepareContent( &$article, &$params, $limitstart )
	{
		if ( $this->params->get('engine', '') == 'highslide' ) {
			if ( !class_exists( 'plgSystemHighslide' ) ) {
				echo '<p style="color: red;">' . JText::_( 'ERROR_HIGHSLIDE_NOT_FOUND' ) . '</p>';
				return;
			}
		} else {
			echo '<p style="color: red;">' . JText::_( 'ENGINE_NOT_DEFINED' ) . '</p>';
			return;
		}

		global $mainframe;
		$this->m_tmbPrefix = 'tmb_';
		$regexImg = "#<img\s*[^>]*src\s*?=\s*?['\"][^<^>]*?" . $this->m_tmbPrefix . "[^<^>]*?\.(jpe?g|gif|png|bmp)['\"][^<^>]*?/>#i";

		preg_match_all( $regexImg, $article->text, $matches );
		$count = count( $matches[0] );
		if ( $count ) {
			$article->text = $this->replaceImg( $article->text, $matches, $count );
		}
	}

	function replaceImg ( $input, &$matches, $count ) 
	{
		$newOutput = $input;

		for ( $i=0; $i < $count; $i++ ) {
			if ( @$matches[0][$i] ) {
				$gImgAlt = $this->getImgAtt( 'alt', $matches[0][$i] );
				$gImgSrc = $this->getImgAtt( 'src', $matches[0][$i] );
				$gImgTitle = $this->getImgAtt( 'title', $matches[0][$i] );
				$gImgAlign = $this->getImgAtt( 'align', $matches[0][$i] );
				$gImgBorder = $this->getImgAtt( 'border', $matches[0][$i] );
				$gImgHspace = $this->getImgAtt( 'hspace', $matches[0][$i] );
				$gImgVspace = $this->getImgAtt( 'vspace', $matches[0][$i] );
				$gImgId = $this->getImgAtt( 'id', $matches[0][$i] );
				$gImgName = $this->getImgAtt( 'name', $matches[0][$i] );
				$gImgUsemap = $this->getImgAtt( 'usemap', $matches[0][$i] );
				$gImgDir = $this->getImgAtt( 'dir', $matches[0][$i] );
				$gWidth = $this->getImgAtt( 'width', $matches[0][$i] );
				$gHeight = $this->getImgAtt( 'height', $matches[0][$i] );
				$gImgStyle = $this->getImgAtt( 'style', $matches[0][$i] );
				$gImgOnClick = $this->getImgAtt( 'onclick', $matches[0][$i] );
				$gImgOnMouseOut = $this->getImgAtt( 'onmouseout', $matches[0][$i] );
				$gImgOnMouseOver = $this->getImgAtt( 'onmouseover', $matches[0][$i] );
			}

			$gParts = explode( '/', $gImgSrc );

			$gFileName = $gParts[count($gParts)-1];
			$gTmbName = $gFileName;
			$gFolder = '';

// TODO: krivo kak-to...
			for ( $t=0; $t < (count($gParts)-1); $t++) {
				$gFolder .= $gParts[$t] . '/';
			}

			$gBigName = str_replace( $this->m_tmbPrefix, '', $gTmbName);

			$rawImg =
				'<img ' .
				$this->checkAttIfEmpty( 'alt', $gImgAlt ) .
				'src="' . $gImgSrc . '" ' .
				$this->checkAttIfEmpty( 'title', $gImgTitle ) .
				$this->checkAttIfEmpty( 'height', $gHeight ) .
				$this->checkAttIfEmpty( 'width', $gWidth ) .
				$this->checkAttIfEmpty( 'class', $this->m_tmbClass ) .
				$this->checkAttIfEmpty( 'align', $gImgAlign ) .
				$this->checkAttIfEmpty( 'border', $gImgBorder ) .
				$this->checkAttIfEmpty( 'hspace', $gImgHspace ) .
				$this->checkAttIfEmpty( 'vspace', $gImgVspace ) .
				$this->checkAttIfEmpty( 'id', $gImgId ) .
				$this->checkAttIfEmpty( 'style', $gImgStyle ) .
				$this->checkAttIfEmpty( 'name', $gImgName ) .
				$this->checkAttIfEmpty( 'usemap', $gImgUsemap ) .
				$this->checkAttIfEmpty( 'dir', $gImgDir ) .
				$this->checkAttIfEmpty( 'onClick', $gImgOnClick ) .
				$this->checkAttIfEmpty( 'onMouseOver', $gImgOnMouseOver ) .
				$this->checkAttIfEmpty( 'onMouseOut', $gImgOnMouseOut ) .
				'/>';

			//Check, if big Image exists

			$linkImage = '';
			if ( $this->params->get('engine', '') == 'highslide' ) {
				$linkImage = '<a href="' . $gFolder . $gBigName . '" class="highslide slow" onclick="return hs.expand(this, grGalleryOptions)">' . $rawImg . '</a>';
			}
			$newOutput = str_replace( $matches[0][$i], $linkImage, $newOutput );
		}
		
		return $newOutput;
	}

	function getImgAtt($imgAtt, $imgMatch)
	{
		$gImgAttValue = '';
		$imgAttMatches = array();
		preg_match( "#" . $imgAtt . "\s*=\s*['\"](.*)['\"]#Ui", $imgMatch, $imgAttMatches );
		if ( isset($imgAttMatches[1]) ) {
			 $gImgAttValue = trim($imgAttMatches[1]);
		}

		if ( $_GET['debug'] == 1 )
		{
			echo "<font color=\"red\">" . htmlentities($imgMatch) . "</font><br>";
			echo $imgAtt . ": " . $gImgAttValue . "<br><br>";
		}

		return $gImgAttValue;
	}

	function checkAttIfEmpty($gAtt, $gString)
	{
		$checkedString = '';
		if ( trim($gString) != '' ) {
			$checkedString = $gAtt . '="' . $gString . '" ';
		}
		return $checkedString;
	}

}
