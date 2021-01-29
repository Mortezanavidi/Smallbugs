<?php

class Time {

	/**
	 * Displays the timestamp's age in human readable format
	 *
	 * @param  int $timestamp
	 * @return string
	 * Modified in nov 2016 to include all languages
	 */
	public static function age($timestamp)	{
		if (empty($timestamp)) {
		    return "No Time";
		}
		$timestamp = (int) $timestamp;
		$difference = time() - $timestamp;
		$periods = array(__('smallbugs.second'),__('smallbugs.minute'),__('smallbugs.hour'),__('smallbugs.day'),__('smallbugs.week'),__('smallbugs.month'),__('smallbugs.year'),__('smallbugs.decade'));
		$lengths = array('60','60','24','7','4.35','12','10');
		
		
		for($j = 0; $difference >= $lengths[$j]; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1) {
			$periods[$j] .= 's';
		}

		return __('smallbugs.since') .  ' '. $difference . ' ' . $periods[$j] . ' ' .  __('smallbugs.ago') . ' ';
	}
}