<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Response\Implementations;

use Casagrande\DaisyBundle\Entity\Publisher\Response\Templates\ADaisyPublisherInlinedTagsConvertor;

class SmartyDaisyPublisherInlinedTagsConvertor extends ADaisyPublisherInlinedTagsConvertor {
	protected $branch;
	protected $language;
	protected $version;
	private $engine;
	
	public function __construct(IDaisyPublisherResponseTemplate $engine) {
		$this->engine = $engine;
	}
	
	public function convertLink(\SimpleXMLElement $a) {
		if (empty($a)) return;
		
		if (!empty($a['href'])) $href = $this->getDocumentHref((string) $a['href']);
		$this->engine->setSource($a);
		$this->engine->setTemplate(TEMPLATES_PATH_CONVERTOR.'a.tpl');
		$this->engine->setCustomVariable('href', $href);
		
		$res['html'] = $this->engine->process();
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
		
		$this->engine->setSource($img);
		$this->engine->setTemplate(TEMPLATES_PATH_CONVERTOR.'img.tpl');
		$this->engine->setCustomVariable('src', htmlentities($src));
		$this->engine->setCustomVariable('originalImg', htmlentities($originalImg));
		
		$res['html'] = $this->engine->process();
		
		return $res;
	}	
	
	public function convertSearchResults(SimpleXMLElement $res) {
		if (empty($res)) return;
		
		$this->engine->setSource($res);
		if ($res['styleHint'] == 'bullets') {
			$this->engine->setTemplate(TEMPLATES_PATH_CONVERTOR.'search.bullets.tpl');
			$result['tagName'] = 'ul';
		}
		else {
			$this->engine->setTemplate(TEMPLATES_PATH_CONVERTOR.'search.table.tpl');
			$result['tagName'] = 'table';
		} 
		
		$result['html'] = $this->engine->process();
		
		return $result;
	}
}

?>