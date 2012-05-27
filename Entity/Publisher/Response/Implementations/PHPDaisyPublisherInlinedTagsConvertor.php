<?php

namespace Casagrande\DaisyBundle\Entity\Publisher\Response\Implementations;

use Casagrande\DaisyBundle\Entity\Publisher\Response\Templates\ADaisyPublisherInlinedTagsConvertor;

class PHPDaisyPublisherInlinedTagsConvertor extends ADaisyPublisherInlinedTagsConvertor {
	protected $branch;
	protected $language;
	protected $version;
	
	public function convertLink(\SimpleXMLElement $a) {
		if (empty($a)) return;
		
		if (!empty($a['href'])) $a['href'] = $this->getDocumentHref((string) $a['href']);

		if (!empty($a->linkInfo)) {
			if (!empty($a->linkInfo['documentName'])) $a['title'] = (string) $a->linkInfo['documentName'];
			unset($a->linkInfo);
		}
		
		$res['html'] = $a->asXML();
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
		
		$img['src'] = $this->getImageSrc((string) $img['src'], 'ImageData');
		
		if (!empty($img->linkInfo)) {
			if (!empty($img->linkInfo['documentName'])) $img['title'] = (string) $img->linkInfo['documentName'];
			unset($img->linkInfo);
		}
		
		if (!empty($img['imageWidth'])) {
			$img['width'] = (string) $img['imageWidth'];
			unset($img['imageWidth']);
		}
		
		if (!empty($img['imageHeight'])) {
			$img['height'] = (string) $img['imageHeight'];
			unset($img['imageHeight']);
		}
				
		$res['html'] = $img->asXML();
		$res['tagName'] = 'img';
		
		return $res;
	}	
	
	public function convertSearchResults(SimpleXMLElement $res) {
		if (empty($res)) return;
		
		$table = "<table border=\"1\">\n";
		$table .= "<tr>\n";
		foreach ($res->titles->title as $title)
			$table .= "<td>\n".$title."</td>\n";
		$table .= "</tr>\n";
		
		foreach ($res->rows->row as $row) {
			$table .= "<tr>\n";
			foreach ($row as $cel)
				$table .= "<td>\n<a href=\"".$this->getDocumentHref("daisy:".$row["documentId"]."@".$row["branchId"].":".$row["languageId"])."\">\n".$cel."</a></td>\n";
			$table .= "</tr>\n";
		}
		
		$table .= "</table>\n";
		
		$result['html'] = $table;
		$result['tagName'] = 'table';
		
		return $result;
	}
			
}

?>
