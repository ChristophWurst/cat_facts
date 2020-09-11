<?php

declare(strict_types=1);

namespace OCA\CatFacts\Command;

use OCA\CatFacts\Service\SearchService;
use OCA\Mail\Service\CleanupService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Search extends Command {

	/** @var CleanupService */
	private $cleanupService;
	/**
	 * @var SearchService
	 */
	private $searchService;

	public function __construct(SearchService $searchService) {
		parent::__construct();

		$this->searchService = $searchService;
	}

	/**
	 * @return void
	 */
	protected function configure() {
		$this->setName('catfacts:search');
		$this->setDescription('Search for cat facts');

		$this->addArgument("term", InputArgument::OPTIONAL);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$facts = $this->searchService->findCatFacts(
			$input->getArgument("term")
		);

		$output->writeln("Here are some facts");
		foreach ($facts as $fact) {
			$output->writeln("* $fact");
		}

		return 0;
	}
}
