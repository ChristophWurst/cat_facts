<?php

declare(strict_types=1);

namespace OCA\CatFacts\Service;

use Exception;
use OCP\Http\Client\IClientService;
use Psr\Log\LoggerInterface;
use function array_filter;
use function array_map;
use function array_values;
use function json_decode;
use function mb_strpos;
use function mb_strtolower;

class SearchService {

	/** @var IClientService */
	private $clientService;

	/** @var LoggerInterface */
	private $logger;

	public function __construct(IClientService $clientService,
								LoggerInterface $logger) {
		$this->clientService = $clientService;
		$this->logger = $logger;
	}

	public function findCatFacts(?string $term = null): array {
		$this->logger->debug('finding the latest cat facts');

		$client = $this->clientService->newClient();

		try {
			$response = $client->get("https://cat-fact.herokuapp.com/facts?animal_type=cat");
		} catch (Exception $e) {
			$this->logger->error("Could not get the latest cat facts. Check if a kitten has bit your internet cable.");

			throw $e;
		}

		$body = $response->getBody();
		$parsed = json_decode($body, true);

		$mapped = array_map(function (array $fact) {
			return $fact['text'];
		}, $parsed['all']);

		if (empty($term)) {
			return array_values($mapped);
		}

		return array_values(
			array_filter($mapped, function (string $fact) use ($term) {
				return mb_strpos(mb_strtolower($fact), mb_strtolower($term));
			})
		);
	}

}
