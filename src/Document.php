<?php namespace ApiRest;

/**
 * TODO - Save for later: HTML document parser
 */
class Document {
	const OPTIONS = [
		XML_OPTION_SKIP_WHITE => 1,
	];

	protected $_parser;
	protected $_dom;
	protected $_text;


	public function __construct(string $body, $encoding='UTF-8') {
		$this->_parser = xml_parser_create_ns($encoding);
		$this->_text = $body;

		// default options
		foreach(static::OPTIONS as $ok=>$ov) {
			xml_parser_set_option($this->_parser, $ok, $ov);
		}


		$this->_dom = xml_parse($this->_parser, $this->_text, true);
	}

	public function __destruct() {
		// free sax parser
		if($this->_parser)
			xml_parser_free($this->_parser);
	}

	public function querySelector(string $selector) {

	}

	public function querySelectorAll(string $selector) {

	}

	/**
	 * concurrent pointer cursor element : defaults to DOM root
	 */
	public function getCursor() {

	}
}