<?php

namespace Drupal\hello_world\EventSubscriber;

use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
* Subscribes to the Kernel Request event and redirects to the homepage
* when the user has the "non_grata" role.
*/
class HelloWorldRedirectSubscriber implements EventSubscriberInterface {

    /**
     * @var \Drupal\Core\Session\AccountProxyInterface
     */
    protected $current_user;

    /**
     * HelloWorldRedirectSubscriber constrcutor.
     * 
     * @param \Drupal\Core\Session\AccountProxyInterface $current_user
     */
    public function __construct(AccountProxyInterface $currentUser) {
        $this->currentUser = $currentUser;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        $events['kernel_request'][] = ['onRequest', 0];
        return $events;
    }

    /**
     * Handler for the kerner request event.
     * 
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        $path = $request->getPathInfo();
        if($path != '/hello') {
            return;
        }

        $roles = $this->currentUser->getRoles();
        if(in_array('non_grata', $roles)) {
            $event->setResponse(new RedirectResponse('/'));
        }
    }
}