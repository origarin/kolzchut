<?php

class ExpandTemplates extends SpecialPage {
	var $generateXML, $removeComments, $removeNowiki, $isNewParser;

	/* 50MB allows fixing those huge pages */
	const MAX_INCLUDE_SIZE = 50000000;

	function __construct() {
		parent::__construct( 'ExpandTemplates' );
	}

	function execute( $subpage ) {
		global $wgParser;

		$this->setHeaders();

		$this->isNewParser = is_callable( array( $wgParser, 'preprocessToDom' ) );

		$request = $this->getRequest();
		$titleStr = $request->getText( 'contexttitle' );
		$title = Title::newFromText( $titleStr );

		if ( !$title ) {
			$title = $this->getTitle();
		}
		$input = $request->getText( 'input' );
		$this->generateXML = $this->isNewParser ? $request->getBool( 'generate_xml' ) : false;

		if ( strlen( $input ) ) {
			$this->removeComments = $request->getBool( 'removecomments', false );
			$this->removeNowiki = $request->getBool( 'removenowiki', false );
			$options = ParserOptions::newFromContext( $this->getContext() );
			$options->setRemoveComments( $this->removeComments );
			$options->setTidy( true );
			$options->setMaxIncludeSize( self::MAX_INCLUDE_SIZE );

			if ( $this->generateXML ) {
				$wgParser->startExternalParse( $title, $options, OT_PREPROCESS );
				$dom = $wgParser->preprocessToDom( $input );

				if ( is_callable( array( $dom, 'saveXML' ) ) ) {
					$xml = $dom->saveXML();
				} else {
					$xml = $dom->__toString();
				}
			}

			$output = $wgParser->preprocess( $input, $title, $options );
		} else {
			$this->removeComments = $request->getBool( 'removecomments', true );
			$this->removeNowiki = $request->getBool( 'removenowiki', false );
			$output = false;
		}

		$out = $this->getOutput();
		$out->addWikiMsg( 'expand_templates_intro' );
		$out->addHTML( $this->makeForm( $titleStr, $input ) );

		if( $output !== false ) {
			global $wgUseTidy, $wgAlwaysUseTidy;

			if ( $this->generateXML ) {
				$out->addHTML( $this->makeOutput( $xml, 'expand_templates_xml_output' ) );
			}

			$tmp = $this->makeOutput( $output );

			if ( $this->removeNowiki ) {
				$tmp = preg_replace(
					array( '_&lt;nowiki&gt;_', '_&lt;/nowiki&gt;_', '_&lt;nowiki */&gt;_' ),
					'',
					$tmp
				);
			}

			if( ( $wgUseTidy && $options->getTidy() ) || $wgAlwaysUseTidy ) {
				$tmp = MWTidy::tidy( $tmp );
			}

			$out->addHTML( $tmp );
			$this->showHtmlPreview( $title, $output, $out );
		}

	}

	/**
	 * Generate a form allowing users to enter information
	 *
	 * @param $title string Value for context title field
	 * @param $input string Value for input textbox
	 * @return string
	 */
	private function makeForm( $title, $input ) {
		$self = $this->getTitle();
		$form  = Xml::openElement(
			'form',
			array( 'method' => 'post', 'action' => $self->getLocalUrl() )
		);
		$form .= "<fieldset><legend>" . $this->msg( 'expandtemplates' )->escaped() . "</legend>\n";

		$form .= '<p>' . Xml::inputLabel(
			$this->msg( 'expand_templates_title' )->plain(),
			'contexttitle',
			'contexttitle',
			60,
			$title,
			array( 'autofocus' => true )
		) . '</p>';
		$form .= '<p>' . Xml::label(
			$this->msg( 'expand_templates_input' )->text(),
			'input'
		) . '</p>';
		$form .= Xml::openElement(
			'textarea',
			array( 'name' => 'input', 'id' => 'input', 'rows' => 10, 'cols' => 10 )
		);

		$form .= htmlspecialchars( $input );
		$form .= Xml::closeElement( 'textarea' );
		$form .= '<p>' . Xml::checkLabel(
			$this->msg( 'expand_templates_remove_comments' )->text(),
			'removecomments',
			'removecomments',
			$this->removeComments
		) . '</p>';
		$form .= '<p>' . Xml::checkLabel(
			$this->msg( 'expand_templates_remove_nowiki' )->text(),
			'removenowiki',
			'removenowiki',
			$this->removeNowiki
		) . '</p>';
		if ( $this->isNewParser ) {
			$form .= '<p>' . Xml::checkLabel(
				$this->msg( 'expand_templates_generate_xml' )->text(),
				'generate_xml',
				'generate_xml',
				$this->generateXML
			) . '</p>';
		}
		$form .= '<p>' . Xml::submitButton(
			$this->msg( 'expand_templates_ok' )->text(),
			array( 'accesskey' => 's' )
		) . '</p>';
		$form .= "</fieldset>\n";
		$form .= Xml::closeElement( 'form' );
		return $form;
	}

	/**
	 * Generate a nice little box with a heading for output
	 *
	 * @param $output string Wiki text output
	 * @param $heading string
	 * @return string
	 */
	private function makeOutput( $output, $heading = 'expand_templates_output' ) {
		$out  = "<h2>" . $this->msg( $heading )->escaped() . "</h2>\n";
		$out .= Xml::openElement(
			'textarea',
			array( 'id' => 'output', 'rows' => 10, 'cols' => 10, 'readonly' => 'readonly' )
		);
		$out .= htmlspecialchars( $output );
		$out .= Xml::closeElement( 'textarea' );
		return $out;
	}

	/**
	 * Render the supplied wiki text and append to the page as a preview
	 *
	 * @param Title $title
	 * @param string $text
	 * @param OutputPage $out
	 */
	private function showHtmlPreview( $title, $text, $out ) {
		global $wgParser;
		$popts = ParserOptions::newFromContext( $this->getContext() );
		$popts->setTargetLanguage( $title->getPageLanguage() );
		$pout = $wgParser->parse( $text, $title, $popts );
		$lang = $title->getPageViewLanguage();
		$out->addHTML( "<h2>" . $this->msg( 'expand_templates_preview' )->escaped() . "</h2>\n" );
		$out->addHTML( Html::openElement( 'div', array(
			'class' => 'mw-content-' . $lang->getDir(),
			'dir' => $lang->getDir(),
			'lang' => $lang->getHtmlCode(),
		) ) );
		$out->addHTML( $pout->getText() );
		$out->addHTML( Html::closeElement( 'div' ) );
	}
}
