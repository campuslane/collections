<?php

namespace Cornernote\Collections\Services\Utilities;

use Cornernote\Collections\Exceptions\StubFileMissing;
use Cornernote\Collections\Exceptions\FileNotWritten;

class FileWriter {

	/**
	 * Stub File Contents
	 * @var string
	 */
	protected $stub;

	/**
	 * Values Array
	 * @var array
	 */
	protected $values;

	/**
	 * Open Tag
	 * @var string
	 */
	protected $openTag;

	/**
	 * Close Tag
	 * @var string
	 */
	protected $closeTag;

	/**
	 * Write the File
	 * @param  string $stub
	 * @param  values $values
	 * @return string
	 */
	public function write($stub, $file, $values, $openTag='', $closeTag='')
	{
		$this->getStub($stub);
		$this->setWriteFile($file);
		$this->setTags($openTag, $closeTag);
		$this->makeReplacements($values);

		return $this->writeFile();
	}

	/**
	 * Set the File Path to Write To
	 * @param string $file
	 */
	private function setWriteFile($file)
	{
		$this->file = $file;
	}

	/**
	 * Set the Token Tags
	 * @param string $openTag
	 * @param string $closeTag
	 */
	private function setTags($openTag, $closeTag)
	{
		$this->openTag = $openTag ?: '{{';
		$this->closeTag = $closeTag ?: '}}';
	}

	/**
	 * Get the Stub File
	 * @param  string $stub
	 * @return string
	 */
	private function getStub($stub)
	{
		if ( ! file_exists($stub)) {
			throw new StubFileMissing($stub);
		}

		return $this->stub = file_get_contents($stub);
	}

	/**
	 * Make Replacements
	 * @return string
	 */
	private function makeReplacements($values)
	{
		foreach($values as $token => $value) {
			$this->stub = str_replace($this->openTag . $token . $this->closeTag, $value, $this->stub);
		}
	}

	/**
	 * Write File
	 * @return boolean
	 */
	private function writeFile()
	{
		$written = file_put_contents($this->file, $this->stub);

		if (! $written) {
			throw new FileNotWritten($this->file);
		}

		return $written;
	}



}