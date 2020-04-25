<?php declare(strict_types=1);

namespace Covid\Output;

use Covid\Consts;
use Covid\Input\Data;
use Covid\Input\InputHandler;
use DateTimeImmutable;

abstract class Generator
{
	/**
	 * @var string
	 */
	protected $generateMode = Consts::GENERATE_FOR_MAIN;

	/**
	 * @var Data
	 */
	protected $data;

	/**
	 * @var string
	 */
	protected $outputPath;

	abstract public function generate();

	abstract protected function saveData();

	/**
	 * @param string $generateMode
	 *
	 * @return Generator
	 */
	public function setGenerateMode(string $generateMode): Generator
	{
		$this->generateMode = $generateMode;

		return $this;
	}

	/**
	 * @param Data $data
	 *
	 * @return Generator
	 */
	public function setData(Data $data): self
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * @param string $americanDate
	 *
	 * @return string
	 */
	protected function getProperlyFormattedDate(string $americanDate): string
	{
		return DateTimeImmutable::createFromFormat('m/d/y', $americanDate)->format('Y-m-d');
	}

	/**
	 * @return array
	 */
	protected function getCountriesForGeneration(): array
	{
		switch ($this->generateMode)
		{
			case Consts::GENERATE_FOR_ALL:
			{
				return $this->data->getCountryNames();
			}
			case Consts::GENERATE_FOR_TEST:
			{
				return $this->data->getTestCountryNames();
			}
			case Consts::GENERATE_FOR_MAIN:
			default:
			{
				return $this->data->getMainCountryNames();
			}
		}
	}

	/**
	 * @return string
	 */
	protected function getBaseFileName(): string
	{
		return InputHandler::DATA_DIR . 'covid_' . $this->generateMode . '_' . date('Y-m-d');
	}

	/**
	 * @return string
	 */
	public function getOutputPath(): string
	{
		return $this->outputPath;
	}
}