<?php

declare(strict_types=1);

namespace OCA\CatFacts\Search;

use OCA\CatFacts\AppInfo\Application;
use OCA\CatFacts\Service\SearchService;
use OCP\IL10N;
use OCP\IUser;
use OCP\Search\IProvider;
use OCP\Search\ISearchQuery;
use OCP\Search\SearchResult;
use OCP\Search\SearchResultEntry;
use function array_map;

class CatFactsProvider implements IProvider {

	/** @var SearchService */
	private $searchService;

	/** @var IL10N */
	private $l10n;

	public function __construct(SearchService $searchService,
								IL10N $l10n) {
		$this->l10n = $l10n;
		$this->searchService = $searchService;
	}

	public function getId(): string {
		return Application::APP_ID;
	}

	public function getName(): string {
		return $this->l10n->t('Cat facts');
	}

	public function getOrder(string $route, array $routeParameters): int {
		return 0; // Cat facts are important, let's face it
	}

	public function search(IUser $user, ISearchQuery $query): SearchResult {
		return SearchResult::complete(
			$this->l10n->t('Cat facts'),
			array_map(function(string $fact) {
				return new SearchResultEntry(
					'',
					$fact,
					$fact,
					'https://cat.facts',
					'icon-mail'
				);
			}, $this->searchService->findCatFacts($query->getTerm()))
		);
	}
}
