<?php
/**
 * @package   akeebabackup
 * @copyright Copyright (c)2006-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

use Awf\Text\Text;

// Protection against direct access
defined('AKEEBAENGINE') or die();

/**
 * Checks if error logs are included inside the backup. Since their size grows while we're trying to backup them,
 * this could led to corrupted archives.
 */
class AliceCoreDomainChecksRuntimeerrorsErrorfiles extends AliceCoreDomainChecksAbstract
{
	public function __construct($logFile = null)
	{
		parent::__construct(80, 'COM_AKEEBA_ALICE_ANALYZE_RUNTIME_ERRORS_ERRORFILES', $logFile);
	}

	public function check()
	{
		$handle = @fopen($this->logFile, 'r');

		if ($handle === false)
		{
			AliceUtilLogger::WriteLog(_AE_LOG_ERROR, $this->checkName . ' Test error, could not open backup log file.');

			return false;
		}

		$prev_data   = '';
		$buffer      = 65536;
		$error_files = array();

		while ( !feof($handle))
		{
			$data = $prev_data . fread($handle, $buffer);

			// Let's find the last occurrence of a new line
			$newLine = strrpos($data, "\n");

			// I didn't hit any EOL char, let's keep reading
			if ($newLine === false)
			{
				$prev_data = $data;
				continue;
			}
			else
			{
				// Gotcha! Let's roll back to its position
				$prev_data = '';
				$rollback  = strlen($data) - $newLine + 1;
				$len       = strlen($data);

				$data = substr($data, 0, $newLine);

				// I have to rollback only if I read the whole buffer (ie I'm not at the end of the file)
				// Using this trick should be much more faster than calling ftell to know where we are
				if ($len == $buffer)
				{
					fseek($handle, -$rollback, SEEK_CUR);
				}
			}

			preg_match_all('#Adding(.*?(/php_error_cpanel\.|php_error_cpanel\.|/error_)log)#', $data, $tmp_matches);

			if (isset($tmp_matches[1]))
			{
				$error_files = array_merge($error_files, $tmp_matches[1]);
			}
		}

		fclose($handle);

		if ($error_files)
		{
			$this->setResult(-1);
			$this->setErrLangKey(array('COM_AKEEBA_ALICE_ANALYZE_RUNTIME_ERRORS_ERRORFILES_FOUND', implode("\n", $error_files)));

			throw new Exception(Text::sprintf('COM_AKEEBA_ALICE_ANALYZE_RUNTIME_ERRORS_ERRORFILES_FOUND', implode('<br/>', $error_files)));
		}

		return true;
	}

	public function getSolution()
	{
		return Text::_('COM_AKEEBA_ALICE_ANALYZE_RUNTIME_ERRORS_ERRORFILES_SOLUTION');
	}
}
