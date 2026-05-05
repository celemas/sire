<?php

declare(strict_types=1);

namespace Duon\Sire;

/** @internal */
final class ErrorBag
{
	/** @var list<Issue> */
	private array $issues = [];

	/** @param list<string|int> $path */
	public function add(array $path, Issue $issue): void
	{
		$this->issues[] = $issue->withPrefix($path);
	}

	/** @param list<string|int> $path */
	public function addNested(array $path, Result $result): void
	{
		foreach ($result->issues() as $issue) {
			$this->add($path, $issue);
		}
	}

	public function hasErrors(): bool
	{
		return $this->issues !== [];
	}

	/** @return list<Issue> */
	public function issues(): array
	{
		return $this->issues;
	}
}
