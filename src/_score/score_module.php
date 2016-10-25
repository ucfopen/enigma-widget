<?php
/**
 * Materia
 * It's a thing
 *
 * @package	    Materia
 * @version    1.0
 * @author     UCF New Media
 * @copyright  2011 New Media
 * @link       http://kogneato.com
 */


/**
 * NEEDS DOCUMENTATION
 *
 * The widget managers for the Materia package.
 *
 * @package	    Main
 * @subpackage  scoring
 * @category    Modules
  * @author      ADD NAME HERE
 */

namespace Materia;

class Score_Modules_EnigmaGS extends Score_Module
{

	private $new_logs = [];
	private $q_ids = null;

	public function check_answer($log)
	{
		if (isset($this->questions[$log->item_id]))
		{
			$q = $this->questions[$log->item_id];
			foreach ($q->answers as $answer)
			{
				if (trim($log->text) == trim($answer['text'])) return $answer['value'];
			}
		}

		return 0;
	}

	protected function handle_log_question_answered($log)
	{
		if ($this->q_ids == null) $this->q_ids = array_keys($this->questions);

		$this->total_questions++;
		$this->verified_score += $this->check_answer($log); // score the question and add it to the total

		// find current log's index from original quetion's array and add to new array
		$q_index = array_search($log->item_id, $this->q_ids);
		$this->new_logs[$q_index] = $log;
	}
}