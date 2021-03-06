<?php
/*
 * Copyright (c) 2015, Sgt. Kabukiman, https://github.com/sgt-kabukiman
 *
 * This file is released under the terms of the MIT license. You can find the
 * complete text in the attached LICENSE file or online at:
 *
 * http://www.opensource.org/licenses/mit-license.php
 */

namespace horaro\WebApp\Exception;

class InputValidationException extends BadRequestException {
	protected $failures;

	public function __construct($message, $code = null, array $failures, \Exception $previous = null) {
		parent::__construct($message, $code, $previous);
		$this->failures = $failures;
	}

	public function getFailures() {
		return $this->failures;
	}
}
