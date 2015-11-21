<?php

namespace Notejam\Presenters;

use Nette;
use Nette\Application\Responses;
use Tracy\ILogger;


/**
 * The default error presenter is used by Nette if an unhandled exception occurs,
 * or the request cannot be translated to an existing and valid presenter.
 */
class ErrorPresenter extends Nette\Object implements Nette\Application\IPresenter
{

	/**
	 * @var ILogger
	 */
	private $logger;



	public function __construct(ILogger $logger)
	{
		$this->logger = $logger;
	}



	/**
	 * This method is usually implemented by the more complex UI\Presenter
	 * But since an unhandled exception might have occurred,
	 * it should be processed as simply as possible to avoid any further problems or even another exception.
	 *
	 * @param Nette\Application\Request $request
	 * @return Responses\CallbackResponse|Responses\ForwardResponse
	 */
	public function run(Nette\Application\Request $request)
	{
		$exception = $request->getParameter('exception');

		// if it's a simple BadRequestException, use the more powerful presenter
		if ($exception instanceof Nette\Application\BadRequestException) {
			return new Responses\ForwardResponse($request->setPresenterName('Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);

		// the 500 means unhandled exception, which should translate to the simplest page possible
		return new Responses\CallbackResponse(
			function () {
				require __DIR__ . '/templates/Error/500.phtml';
			}
		);
	}

}
