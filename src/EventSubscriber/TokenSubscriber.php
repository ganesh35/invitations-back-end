<?php
// src/EventSubscriber/TokenSubscriber.php
namespace App\EventSubscriber;

use App\Controller\TokenAuthenticatedController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Component\DependencyInjection\Container;

class TokenSubscriber implements EventSubscriberInterface
{
    /**
     * @var keys
     */
    private $keys;

    /**
     * Constructor
     *
     * @param Container $keys 
     */
    public function __construct($keys)
    {
            $this->keys = $keys;
    }

    public function onKernelController(FilterControllerEvent  $event){
        $controller = $event->getController();
         /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof TokenAuthenticatedController) {
            $token = $event->getRequest()->headers->get('authorization');
            $valid_token=$this->validateToken($token);
            if (empty($valid_token)) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }
            
            $event->getRequest()->attributes->set('auth_token', $valid_token);
            //$event->getRequest()->attributes->set('jwks', $this->keys);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }

    /*
    * Validating a JWT token
    * Simple validation
    * ToDo: Validations must be done based on https://docs.aws.amazon.com/cognito/latest/developerguide/amazon-cognito-user-pools-using-tokens-verifying-a-jwt.html
    */
    private function validateToken($token){
        if(empty($token)) return false;
        $tokenParts = explode(".", str_replace("bearer ", "", $token));
        if(count($tokenParts) != 3) return false;
        $decodedToken =  [
            'header' => json_decode(base64_decode($tokenParts[0]), true),
            'payload' => json_decode(base64_decode($tokenParts[1]), true),
            'signature' => json_decode(base64_decode($tokenParts[2]), true),
        ];
        return [ 
            'name' => $decodedToken['payload']['name'], 
            'email' => $decodedToken['payload']['email'], 
            'username' => $decodedToken['payload']['cognito:username']  
        ];
    }
}
