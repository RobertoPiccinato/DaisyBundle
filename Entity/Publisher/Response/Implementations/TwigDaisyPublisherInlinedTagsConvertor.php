<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Response\Implementations;

use Casagrande\DaisyBundle\Entity\Publisher\Response\Templates\ADaisyPublisherInlinedTagsConvertor;

class TwigDaisyPublisherInlinedTagsConvertor extends ADaisyPublisherInlinedTagsConvertor {
	protected $branch;
	protected $language;
	protected $version;
	private $engine;
	
	public function __construct(IDaisyPublisherResponseTemplate $engine) {
		$this->engine = $engine;
	}
	
	public function convertLink(\SimpleXMLElement $a) {
		if (empty($a)) return;
		
		$href = !empty($a['href']) ? $this->getDocumentHref((string) $a['href']) : '';
		
		$title = $a->linkInfo.documentName;
		
		$res['html'] = $this->engine->render('CasagrandeDaisyBundle:PublisherResponse:a.html.twig', array(
				'href' => $href,
				'title' => $title,
				'source' => $a));
		$res['tagName'] = 'a';
		
		return $res;
	}
	
	public function getDocumentHref($daisyLink) {
		if (empty($daisyLink)) return '';
		try {
			$link = $this->explodeDaisyLink($daisyLink);
		}
		catch (EDaisyWrongDaisyLink $e) {
			return htmlspecialchars($daisyLink);
		}
		
		$href = 'http://localhost/DaisyLib/test.php?';
		
		if (!empty($link['id'])) $href .= 'id='.$link['id'].'&';
		if (!empty($link['branch'])) $href .= 'branch='.$link['branch'].'&';
		if (!empty($link['language'])) $href .=  'language='.$link['language'].'&';
		if (!empty($link['version'])) $href .=  'version='.$link['version'].'&';
		
		return htmlspecialchars($href);
	}
	
	public function getImageSrc($daisyLink, $part) {
		if (empty($daisyLink)) return '';
		
		try {
			$link = $this->explodeDaisyLink($daisyLink);
		}
		catch (EDaisyWrongDaisyLink $e) {
			return htmlspecialchars($daisyLink);
		}
		$href = 'http://localhost:9263/publisher/blob?';
		
		if (!empty($link['id'])) $href .= 'documentId='.$link['id'].'&';
		if (!empty($link['branch'])) $href .= 'branch='.$link['branch'].'&';
		if (!empty($link['language'])) $href .=  'language='.$link['language'].'&';
		if (!empty($link['version'])) $href .=  'version='.$link['version'].'&';
		
		if (!empty($part)) $href .= 'partType='.$part;
		
		return htmlspecialchars($href);
	}
	
	public function convertImageLink(\SimpleXMLElement $img) {
		if (empty($img) || empty($img['src'])) return;
		
		$src = (string) $img['src'];
		$originalImg = '';		
		
		if((!empty($img['imageWidth'])) && (!empty($img['imageHeight']))
			&& ($img['imageWidth'] > 500 || $img['imageHeight'] > 500)) {
			$originalImg = $this->getImageSrc($src, 'ImageData');
			$src = $this->getImageSrc($src, 'ImagePreview');
			$res['tagName'] = 'a';
		}
		else  {
			$src = $this->getImageSrc($src, 'ImageData');
			$res['tagName'] = 'img';
		}
			
		$res['html'] = $this->engine->render('CasagrandeDaisyBundle:PublisherResponse:img.html.twig', array(
				'src' => htmlentities($src),
				'originalImg' => htmlentities($originalImg),
				'title' => $img->linkInfo.documentName));
		
		return $res;
	}	
	
	public function convertSearchResults(\SimpleXMLElement $res) {
		if (empty($res)) return;
		
		$rows = $res->rows;
		
		$this->engine->setSource($res);
		if ($res['styleHint'] == 'bullets') {
			$result['html'] = $this->engine->render('CasagrandeDaisyBundle:PublisherResponse:searchBullets.html.twig', array(
					'rows' => $rows));
			$result['tagName'] = 'ul';
		}
		else {
			$result['html'] = $this->engine->render('CasagrandeDaisyBundle:PublisherResponse:searchTable.html.twig', array(
					'rows' => $rows,
					'source' => $res));
			$result['tagName'] = 'table';
		} 
		
		return $result;
	}
	
}

?>
