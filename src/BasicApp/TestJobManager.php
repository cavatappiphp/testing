<?php

namespace Cavatappi\Test\BasicApp;

use Cavatappi\Foundation\Job\Job;
use Cavatappi\Foundation\Job\JobManager;
use Psr\Container\ContainerInterface;

/**
 * A stupidly simple Job Manager.
 */
final class TestJobManager implements JobManager {
	/**
	 * Basic job queue.
	 *
	 * @var array
	 */
	private array $queue = [];

	/**
	 * @param ContainerInterface $container Stores services used by Jobs.
	 */
	public function __construct(private ContainerInterface $container) {
	}

	/**
	 * Set a Job for later processing.
	 *
	 * @param Job $job Job to enqueue.
	 * @return void
	 */
	public function enqueue(Job $job): void {
		// TODO: add serialization before enquing.
		$this->queue[] = $job;
	}

	/**
	 * Process the enqueued jobs.
	 *
	 * @return void
	 */
	public function run(): void {
		$job = \array_shift($this->queue);
		if (isset($job)) {
			\call_user_func(
				[$this->container->get($job->service), $job->method],
				...$job->getParameters()
			);
			$this->run();
		}
	}
}
