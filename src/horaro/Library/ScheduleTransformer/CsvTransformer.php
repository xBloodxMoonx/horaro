<?php
/*
 * Copyright (c) 2014, Sgt. Kabukiman, https://bitbucket.org/sgt-kabukiman/
 *
 * This file is released under the terms of the MIT license. You can find the
 * complete text in the attached LICENSE file or online at:
 *
 * http://www.opensource.org/licenses/mit-license.php
 */

namespace horaro\Library\ScheduleTransformer;

use horaro\Library\Entity\Schedule;

class CsvTransformer extends BaseTransformer {
	const DATE_FORMAT = 'r';

	public function getContentType() {
		return 'text/csv; charset=UTF-8';
	}

	public function getFileExtension() {
		return 'csv';
	}

	public function transform(Schedule $schedule) {
		$rows      = [];
		$cols      = $schedule->getColumns();
		$scheduled = $schedule->getLocalStart();
		$toCSV     = function($val) {
			return '"'.addcslashes($val, '"').'"';
		};

		$header = [$toCSV('Scheduled'), $toCSV('Length')];

		foreach ($cols as $col) {
			$header[] = $toCSV($col->getName());
		}

		$rows[] = implode(';', $header);

		foreach ($schedule->getItems() as $item) {
			$extra = $item->getExtra();
			$row   = [
				'scheduled' => $toCSV($scheduled->format(self::DATE_FORMAT)),
				'length'    => $toCSV($item->getLength()->format('H:i:s'))
			];

			foreach ($cols as $col) {
				$colID = $col->getId();
				$row[] = isset($extra[$colID]) ? $toCSV($extra[$colID]) : '';
			}

			$rows[] = implode(';', $row);
			$scheduled->add($item->getDateInterval());
		}

		return implode("\n", $rows);
	}
}
