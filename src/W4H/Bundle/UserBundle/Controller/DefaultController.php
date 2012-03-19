<?php

namespace W4H\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 * @licence: GPL
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/user/data.{_format}", name="user_data")
     */
    public function getDataAction(Request $request)
    {
        $data = array('authentified' => false);
        $format = $request->getRequestFormat();

        if ($request->getMethod() == 'POST') {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $userManager = $this->get('fos_user.user_manager');
            $person = $userManager->findUserByUsername($username);

            if($person) {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($person);
                $encodedPassword = $encoder->encodePassword($password, $person->getSalt());

                if($person->getPassword() == $encodedPassword) {
                    $data['authentified'] = true;
                    $data['account'] = array(
                        'firstname' => $person->getFirstName(),
                        'lastname'  => $person->getLastName(),
                        'email'     => $person->getEmail()
                    );
                }
            }
        }

        if($format == 'json') {
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
        }

        if($format == 'xml') {
            $xml = new \SimpleXMLElement('<?xml version="1.0"?><authentication></authentication>');
            self::arrayToXml($data, $xml);
            $response = new Response($xml->asXML());
            $response->headers->set('Content-Type', 'application/xml');
        }

        return $response;
    }

    public static function arrayToXml($data, &$xml)
    {
        foreach($data as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml->addChild("$key");
                    self::arrayToXml($value, $subnode);
                }
                else{
                    self::arrayToXml($value, $xml);
                }
            }
            else {
                $xml->addChild("$key","$value");
            }
        }
    }
}

