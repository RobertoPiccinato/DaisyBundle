<?php

namespace Casagrande\DaisyBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Casagrande\DaisyBundle\Entity\DaisyUser;
use Casagrande\DaisyBundle\Entity\DaisyHTTPClient;
use Casagrande\DaisyBundle\Entity\Repository\Repository;
use Casagrande\DaisyBundle\Entity\Repository\User;

use Casagrande\DaisyBundle\Entity\Publisher\Request\DaisyPublisherRequest;
use Casagrande\DaisyBundle\Entity\Publisher\Response\DaisyPublisherResponsePreparedDocuments;
use Casagrande\DaisyBundle\Entity\Publisher\Response\DaisyPublisherHtmlPart;
use Casagrande\DaisyBundle\Entity\Implementations\Classes\PHPDaisyPublisherInlinedTagsConvertor;
use Casagrande\DaisyBundle\Entity\Implementations\Classes\TwigDaisyPublisherInlinedTagsConvertor;
use Casagrande\DaisyBundle\Entity\Implementations\Classes\TwigDaisyPublisherResponseTemplate;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('CasagrandeDaisyBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function testPublisherAction()
    {
		
		//repository connection parameters
		define('REPOSITORY_HOST', 'localhost');
		define('REPOSITORY_PORT', '9263');
		define('REPOSITORY_USER', 'testuser');
		define('REPOSITORY_PASSWORD', 'testuser');
				
		//create HTTP connection client and set connection properties 
		$client = DaisyHTTPClient::singleton();
		$client->connect(REPOSITORY_HOST, REPOSITORY_PORT);
		//create publisher request from a particular user
		$req = new DaisyPublisherRequest(new DaisyUser(REPOSITORY_USER, REPOSITORY_PASSWORD));
		
		//add <p:document> tag to the request and set some of its properties
		$doc = $req->addDocument('1-CAS', 'main', 'en', '1');
		//add <p:preparedDocumet> tag to the <p:document>
		$doc->addPreparedDocuments();
		//add all the tags that can be contained by <p:preparedDocument> 
		$doc->addComments();
		$doc->addAvailableVariants();
		$doc->addAclInfo();
		$doc->addSubscriptionInfo();
		//trying out different publisher requests
		
		$doc->addShallowAnnotatedVersion();
		
		$doc->addAnnotatedDocument();
		
		$doc->addAnnotatedVersionList();
		
		$dif = $doc->addDiff();
		//$dif->addOtherDocument(2, 1, 1, 1);
		
		$req->addMyComments();
		
		$tree = $doc->addNavigationTree();
		$tree->addNavigationDocument(1, 1, 'default');
		$tree->addActiveDocument('1-CAS', 'main', 'en');
		$tree->addContextualized(false);
		
		//$req->addPerformQuery()->addQuery("select id, name where InCollection('main') and branch = 'main' and language = 'ua'");
		
		//$req->addIf('true')->addPerformQuery()->addQuery("select id, name where InCollection('main') and branch = 'main' and language = 'ua'");
		
		//$foreach = $req->addForEach();
		//$foreach->addQuery("select id, name where InCollection('main') and branch = 'main' and language = 'ua'");
		//@$foreach->addDocument($_GET['id'], $_GET['branch'], $_GET['language'], $_GET['version']);
		
		//@$req->addGroup('1')->addDocument($_GET['id'], $_GET['branch'], $_GET['language'], $_GET['version'])->addComments();
		//$tree = $req->addGroup('2')->addNavigationTree();
		//$tree->addNavigationDocument(1, 1, 'default');
		//$tree->addActiveDocument($_GET['id'], $_GET['branch'], $_GET['language']);
		//$tree->addContextualized(false);
		
		//@$req->addResolveDocumentIds($_GET['branch'], $_GET['language'])->addDocument($_GET['id'], $_GET['branch'], $_GET['language'], $_GET['version']);
		
		
		//send publisher request to the repository server
		$req->sendRequest();
		//exit;

		$content = $req->getResponse();
		$content = trim($content);
		
		$response = new Response();
		$response->setContent($content);
		$response->headers->set('Content-Type', 'text/xml');
		
		return $response;
		
		//initialize Twig template engine object
		$engine = $this->container->get('templating');
		
		//initialize XSLT processor
		//$engine = new XSLTProcessor();
		
		//create response object from the repository server reply
		$resp = DaisyPublisherResponse::processResponse(
				new TwigDaisyPublisherInlinedTagsConvertor(new TwigDaisyPublisherResponseTemplate($engine)),
				$req->getResponse());
		
		$preparedDoc = new DaisyPublisherResponsePreparedDocuments($resp,
				new TwigDaisyPublisherResponseTemplate($engine),															
				new PHPDaisyPublisherInlinedTagsConvertor());
		$preparedDoc->defaultDocumentTemplate = 'preparedDoc.tpl';
		$preparedDoc->preparedDocumentsTemplate = TEMPLATES_PATH.'preparedDocs.tpl';
		$preparedDoc->errorTemplate = TEMPLATES_PATH.'error.tpl';
		$preparedDoc->setCustomTemplate('Image', TEMPLATES_PATH.'preparedDocImage.tpl');
		$res = $preparedDoc->process();
		echo $res[0]['html'];

    }
    
    public function testAction() {
    	
    	$casUser = new DaisyUser('testuser', 'testuser');
    	
    	$daisyRepository = new Repository($casUser);
    	
    	$daisyRepository->sendGet('/repository/userIds');
    	
    	$response = new Response();
		$response->setContent($daisyRepository->getResponse());
		$response->headers->set('Content-Type', 'text/xml');
		
		return $response;
    	
    }
}
