<?php
/**
 * @package Addon Library
 * @author UniteCMS.net
 * @copyright (C) 2012 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('ADDON_LIBRARY_INC') or die('Restricted access');

class UniteCreatorAddonConfig extends HtmlOutputBaseUC{
	
	const VIEW_COMBINED = "combined";
	const VIEW_TABS = "tabs";
	
	private $startWithAddon = false;
	private $isPreviewMode = false;
	private $startAddon;
	private $hasItems = null;
	private $view = null;
	private static $arrFontPanelData;
	
	
	/**
	 * construct the object
	 */
	public function __construct(){
		
		$this->view = self::VIEW_COMBINED;
	
	}
	
	
	/**
	 * validate start addon
	 */
	private function valdiateStartAddon(){
		
		if($this->startWithAddon == false)
			UniteFunctionsUC::throwError("No start addon found");
	
	}
	
	
	/**
	 * get preview html
	 */
	private function getHtmlPreview(){
		$html = "";
		
		//preview
		$html .= self::TAB2."<div class='uc-addon-config-preview' style='display:none'>".self::BR;
		$html .= 	self::TAB3."<div class='uc-addon-config-preview-title'>Preview".self::BR;
		$html .= 	self::TAB3."</div>".self::BR;
		
		$html .= 	self::TAB3."<div class='uc-preview-content'>".self::BR;
		
		$html .= 	self::TAB4."<iframe class='uc-preview-iframe'>".self::BR;
		$html .= 	self::TAB4."</iframe>".self::BR;
		
		$html .= 	self::TAB3."</div>".self::BR;
		
		$html .= 	self::TAB2."</div>".self::BR;
		
		return($html);
	}
	
	
	/**
	 * get items html
	 */
	public function getHtmlItems($putMode = false){
		
		$objManager = new UniteCreatorManagerInline();
		if($this->startWithAddon)
			$objManager->setStartAddon($this->startAddon);
		
		
		$html = "";
		
		$html .= self::TAB3."<div class='uc-addon-config-items'>".self::BR;
		
		if($this->view == self::VIEW_COMBINED)
			$html .= self::TAB3."<div class='uc-addon-config-title'>".__("Edit Items", ADDONLIBRARY_TEXTDOMAIN)."</div>".self::BR;
		
		if($this->startWithAddon){
			
			if($putMode == true){
				echo $html;
				$html = "";
				
				$objManager->outputHtml();
			
			}else{
				ob_start();
				$objManager->outputHtml();
				
				$itemsContent = ob_get_contents();
				
				$html .= $itemsContent;
				
				ob_clean();
				ob_end_clean();
			}
		
		}//only if start addon presents
		
		$html .= self::TAB3."</div>".self::BR;
		
		
		if($putMode == true){
			echo $html;
		}else		
			return($html);
	}

	
	/**
	 * get item settings html
	 */
	private function getHtmlSettings($putMode = false){
		
		$html = "";
		
		$html .= 	self::TAB3."<div class='uc-addon-config-settings unite-settings'>".self::BR;
		
		if($putMode == true){
			echo $html;
			$html = "";
		}
		
		if($this->startWithAddon == true){
		
			if($putMode == true)
				$this->startAddon->putHtmlConfig();
			else{
				$htmlConfig = $this->startAddon->getHtmlConfig();
				$html .= $htmlConfig;
			}
		}
		
		$html .= self::TAB3."</div>".self::BR;	//settings
		
		
		if($putMode == true)
			echo $html;
		else		
			return($html);
	}
	
	
	private function a_____________FONTS_______________(){}
	
	
	/**
	 * get main params names
	 */
	private function getParamsNamesForFonts($paramsType){
		
		switch($paramsType){
			case "main":
				$arrParams = $this->startAddon->getParams();
			break;
			case "items":
				$arrParams = $this->startAddon->getParamsItems();
			break;
			default:
				UniteFunctionsUC::throwError("Wrong params type: $paramsType");
			break;
		}
		
		
		$arrNames = array();
		foreach($arrParams as $param){
			
			$name = UniteFunctionsUC::getVal($param, "name");
			$title = UniteFunctionsUC::getVal($param, "title");
			
			if($paramsType == "items"){
				$name = "uc_items_attribute_".$name;
				$title = __("Items", ADDONLIBRARY_TEXTDOMAIN)." => ".$title;
			}
			
			$fontEditable = UniteFunctionsUC::getVal($param, "font_editable");
			$fontEditable = UniteFunctionsUC::strToBool($fontEditable);
			
			if($fontEditable == true)
				$arrNames[$name] = $title;
			
		}
		
		return($arrNames);
	}
	
	
	/**
	 * get fonts panel html fields
	 */
	private function getFontsPanelHtmlFields($arrParams, $arrFontsData){
		
		$arrData = HelperUC::getFontPanelData();
		
		//get last param name
		end($arrParams);
		$lastName = key($arrParams);
		
		$html = "<div class='uc-fontspanel'>";
		
		$counter = 0;
		
		$br = "\n";
		foreach ($arrParams as $name => $title):
			
			 $counter++;
		     $sectionID = "uc_fontspanle_section_".$counter;
			 
		     $fontData = UniteFunctionsUC::getVal($arrFontsData, $name);
			 $isDataExists = !empty($fontData);
			 
			 
			 $fontFamily = UniteFunctionsUC::getVal($fontData, "font-family");
			 $fontWeight = UniteFunctionsUC::getVal($fontData, "font-weight");
			 $fontSize = UniteFunctionsUC::getVal($fontData, "font-size");
			 $lineHeight = UniteFunctionsUC::getVal($fontData, "line-height");
			 $textDecoration = UniteFunctionsUC::getVal($fontData, "text-decoration");
			 $mobileSize = UniteFunctionsUC::getVal($fontData, "mobile-size");
			 $fontStyle = UniteFunctionsUC::getVal($fontData, "font-style");
			 
			 $color = UniteFunctionsUC::getVal($fontData, "color");
			 $color = htmlspecialchars($color);
			 
			 $customStyles = UniteFunctionsUC::getVal($fontData, "custom");
			 $customStyles = htmlspecialchars($customStyles);
			 
			 
			 $classInput = "uc-fontspanel-field";
			 
			 $selectFontFamily = HelperHtmlUC::getHTMLSelect($arrData["arrFontFamily"],$fontFamily,"data-fieldname='font-family' class='{$classInput}'", true, "not_chosen", __("Select Font Family", ADDONLIBRARY_TEXTDOMAIN));
			 $selectFontWeight = HelperHtmlUC::getHTMLSelect($arrData["arrFontWeight"],$fontWeight,"data-fieldname='font-weight' class='{$classInput}'", false, "not_chosen", __("Select Font Weight", ADDONLIBRARY_TEXTDOMAIN));
			 $selectFontSize = HelperHtmlUC::getHTMLSelect($arrData["arrFontSize"],$fontSize,"data-fieldname='font-size' class='{$classInput}'", false, "not_chosen", __("Select Font Size", ADDONLIBRARY_TEXTDOMAIN));
			 $selectLineHeight = HelperHtmlUC::getHTMLSelect($arrData["arrLineHeight"],$lineHeight,"data-fieldname='line-height' class='{$classInput}'", false, "not_chosen", __("Select Line Height", ADDONLIBRARY_TEXTDOMAIN));
			 $selectTextDecoration = HelperHtmlUC::getHTMLSelect($arrData["arrTextDecoration"],$textDecoration,"data-fieldname='text-decoration' class='{$classInput}'", false, "not_chosen", __("Select Text Decoration", ADDONLIBRARY_TEXTDOMAIN));
			 $selectMobileSize = HelperHtmlUC::getHTMLSelect($arrData["arrMobileSize"],$mobileSize,"data-fieldname='mobile-size' class='{$classInput}'", false, "not_chosen", __("Select Mobile Size", ADDONLIBRARY_TEXTDOMAIN));
			 $selectFontStyle = HelperHtmlUC::getHTMLSelect($arrData["arrFontStyle"],$mobileSize,"data-fieldname='font-style' class='{$classInput}'", false, "not_chosen", __("Select Style", ADDONLIBRARY_TEXTDOMAIN));
			 
			 $classSection = "uc-fontspanel-details";			 
			 
			 $htmlChecked = "";
			 $contentAddHtml = "style='display:none'";
			 
			 if($isDataExists == true){
			 	$htmlChecked = "checked ";
			 	$contentAddHtml = "";
			 }
			 
			 $html .= "<label class=\"uc-fontspanel-title\">".$br;
			 $html .=    "<input data-target=\"{$sectionID}\" {$htmlChecked}data-sectionname=\"{$name}\" type=\"checkbox\" onfocus='this.blur()' class='uc-fontspanel-toggle' /> {$title}".$br;
			 $html .= " </label>";
			 
		     $html .= "<div id='{$sectionID}' class='uc-fontspanel-section' {$contentAddHtml}>	".$br;
		    	
		     $html .= "<div class=\"uc-fontspanel-line\">".$br;
		     
		     $html .= "<span class=\"{$classSection}\">".$br;
		     $html .= " 			".__("Font Family", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
		     $html .= "		".$selectFontFamily.$br;
		     $html .= "</span>".$br;
		     
		     $html .= "<span class=\"{$classSection}\">".$br;
		     $html .= "			".__("Font Weight", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
		     $html .= "		".$selectFontWeight.$br;
		     $html .= "</span>".$br;
		      	
		     $html .= "<span class=\"{$classSection}\">".$br;
		     $html .= "			".__("Font Size", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
		     $html .= "		".$selectFontSize.$br;
		     $html .= "	</span>".$br;
		     
		     $html .= "<span class=\"{$classSection}\">".$br;
		     $html .= "		".__("Line Height", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
		     $html .= "		".$selectLineHeight.$br;
		     $html .= "</span>".$br;
		     
		     $html .= "</div>".$br;	//line
		     
		     $html .= "<div class=\"uc-fontspanel-line\">".$br;
		     		      			      		
	      	 $html .= "<span class=\"{$classSection}\">".$br;
	      	 $html .= "	".__("Text Decoration", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
	      	 $html .= $selectTextDecoration;
	      	 $html .= "</span>".$br;
		      	
	      	 $html .= "<span class=\"{$classSection}\">".$br;
	      	 $html .= "	".__("Color", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
	      	 $html .= "	<input type=\"text\" data-fieldname='color' value=\"{$color}\" class=\"unite-color-picker {$classInput}\">	".$br;
	      	 $html .= "</span>".$br;
		     
	      	 $html .= "<span class=\"{$classSection}\">".$br;
	      	 $html .= "	".__("Mobile Font Size", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
	      	 $html .= "	".$selectMobileSize.$br;
	      	 $html .= "</span>".$br;
	      	 
	      	 $html .= "<span class=\"{$classSection}\">".$br;
	      	 $html .= "	".__("Font Style", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
	      	 $html .= $selectFontStyle;
	      	 $html .= "</span>".$br;
	      	 
	      	 $html .= "<span class=\"{$classSection}\">".$br;
	      	 $html .= "	".__("Custom Styles", ADDONLIBRARY_TEXTDOMAIN)."<br>".$br;
	      	 $html .= "	<input type=\"text\" data-fieldname='custom' value=\"{$customStyles}\" class=\"{$classInput}\">	".$br;
	      	 $html .= "</span>".$br;
	      	 
		     $html .= "	</div>".$br;    				      
		     $html .= "</div>".$br;
		    
		    if($name != $lastName) 
		    	$html .= "<div class='uc-fontspanel-sap'></div>";
		    
		    $html .= "<div class='unite-clear'></div>".$br;
		    
		endforeach;
				
		$html .= "</div>".$br;
		
		$html .= "<div class='unite-clear'></div>".$br;
		
		return($html);
	}
	
	/**
	 * get all params names for font panel
	 */
	public function getAllParamsNamesForFonts(){
		
		$arrParamsNamesMain = $this->getParamsNamesForFonts("main");
		$arrParamsNamesItems = $this->getParamsNamesForFonts("items");
		$arrParamsNames = array_merge($arrParamsNamesMain, $arrParamsNamesItems);
		
		return($arrParamsNames);
	}
	
	
	/**
	 * fonts panel html
	 */
	public function getHtmlFontsPanel($arrParamsNames, $putHtml = false){
		
		$this->valdiateStartAddon();
		
		$arrFontsData = $this->startAddon->getArrFonts();
		
		$html = "";
		
		if(empty($arrParamsNames)){
			
			$html .= "<div class='uc-fontspanel-message'>";
			$html .= "Font overrides are disabled for this addon. If you would like to enable them please contact our support at <a href='https://unitecms.ticksy.com' target='_blank'>unitecms.ticksy.com</a>";
			$html .= "</div>";
			
		}else{
						
			$html .= self::TAB3."<div class='uc-addon-config-fonts'>".self::BR;
			$html .= "<h2>".__("Edit Fonts", ADDONLIBRARY_TEXTDOMAIN)."</h2>";
			
			$html .= $this->getFontsPanelHtmlFields($arrParamsNames, $arrFontsData);
			
			$html .= self::TAB3."</div>";
		}
		
		
		if($putHtml == true)
			echo $html;
		else
			return($html);
	}
	
	
	private function a_____________OTHERS_______________(){}
	
	
	/**
	 * put html frame of the config
	 */
	public function getHtmlFrame($putMode = false){
		
		$title = __("Addon Title", ADDONLIBRARY_TEXTDOMAIN);
		$this->valdiateStartAddon();
		
		$addHtml = "";
		$title = $this->startAddon->getTitle(true);
		$title .= " - ".__("Config", ADDONLIBRARY_TEXTDOMAIN);
		
		$titleSmall = $this->startAddon->getTitle(true);
		
		$addonName = $this->startAddon->getNameByType();
		$addonID = $this->startAddon->getID();
		$addonType = $this->startAddon->getType();
		$arrFontsParamNames = $this->getAllParamsNamesForFonts();
		$enableFontsPanel = true;
		
		$options = $this->startAddon->getOptions();
		$urlIcon = $this->startAddon->getUrlIcon();
		
		$options["title"] = $this->startAddon->getTitle();
		$options["url_icon"] = $urlIcon;
		$options["addon_name"] = $addonName;
		$options["addon_id"] = $addonID;
		$options["addon_type"] = $addonType;
		
		$strOptions = UniteFunctionsUC::jsonEncodeForHtmlData($options,"options");
		
		$addHtml .= " data-name=\"{$addonName}\" data-addontype=\"{$addonType}\" {$strOptions} ";
		$addHtml .= " data-view=\"{$this->view}\"";
				
		$html = "";
		
		//settings
		$html .= self::TAB. "<div id='uc_addon_config' class='uc-addon-config' {$addHtml}>".self::BR;
		
		//set preview style
		$styleConfigTable = "";
		if($this->isPreviewMode == true)
			$styleConfigTable = "style='display:none'";
		
		if($this->view == self::VIEW_TABS){
			
			$html .= self::TAB."<div class='uc-addon-config-table'>".self::BR;
			
			$html .= self::TAB2."<div id='uc_addon_config_tabs' class='uc-addon-config-tabs-wrapper'>".self::BR;
			$html .= self::TAB3."<a href='javascript:void(0)' data-name='config' onfocus='this.blur()' class='uc-addon-config-tab uc-tab-selected'>".__("Config", ADDONLIBRARY_TEXTDOMAIN)."</a>".self::BR;
			
			//add items tab
			if($this->hasItems == true)
				$html .= self::TAB3."<a href='javascript:void(0)' data-name='items' onfocus='this.blur()' class='uc-addon-config-tab uc-last-tab'>".__("Items", ADDONLIBRARY_TEXTDOMAIN)."</a>".self::BR;
			
			if($enableFontsPanel == true)
				$html .= self::TAB3."<a href='javascript:void(0)' data-name='fonts' onfocus='this.blur()' class='uc-addon-config-tab uc-last-tab'>".__("Fonts", ADDONLIBRARY_TEXTDOMAIN)."</a>".self::BR;
			
			$html .= self::TAB2."<div class='uc-addon-config-tabs-addontitle'>{$titleSmall}</div>".self::BR;
			
			$html .= self::TAB2."</div>".self::BR;
						
		}
		
		//put table
		if($this->view == self::VIEW_COMBINED){
			
			if($this->hasItems == true){
				$html .= self::TAB2."<table id='uc_addon_config_table' class='uc-addon-config-table' {$styleConfigTable}>".self::BR;
				$html .= self::TAB3."<tr>".self::BR;
				$html .= self::TAB4."<td class='uc-addon-config-cell-left'>".self::BR;
				$html .= self::TAB5."<div class='uc-addon-config-left'>".self::BR;
			}else{
				$html .= "<div class='uc-addon-config-table'>";
			}
			
			//put title
			$html .= 	self::TAB3."<div class='uc-addon-config-title'>$title</div>".self::BR;
		}
		
		if($this->view == self::VIEW_TABS){
			
			$html .= self::TAB2."<div id='uc_addon_config_tab_config' class='uc-addon-config-tab-content'>".self::BR;
		}
		
		//put settings
		if($putMode == true){
			echo $html;
			$html = "";
			$this->getHtmlSettings(true);
		}else{
			$html .= $this->getHtmlSettings();
		}
		
		if($this->view == self::VIEW_TABS){
			$html .= self::TAB2."</div>";
		}
		
		if($this->view == self::VIEW_COMBINED && $this->hasItems){
		
			$html .= self::TAB5."</div>".self::BR;
			$html .= self::TAB4."</td>".self::BR;
			
			//end cell left
			$html .= self::TAB4."<td class='uc-addon-config-cell-right'>".self::BR;
		}
		
		if($this->view == self::VIEW_TABS){
			
			$html .= self::TAB2."<div id='uc_addon_config_tab_items' class='uc-addon-config-tab-content' style='display:none'>".self::BR;
		}
		
		//put items
		if($this->hasItems == true){
			
			if($putMode == true){
				echo $html;
				$html = "";
				$this->getHtmlItems(true);
			}else{
				$html .= $this->getHtmlItems();
			}
		}
		
		if($this->view == self::VIEW_TABS){
			$html .= self::TAB2."</div>";
			
			//put fonts tab
			if($enableFontsPanel == true){
				
				$html .= self::TAB2."<div id='uc_addon_config_tab_fonts' class='uc-addon-config-tab-content' style='display:none'>".self::BR;
				
				if($putMode == true){
					echo $html;
					$html = "";
					$this->getHtmlFontsPanel($arrFontsParamNames,true);
				}else{
					$html .= $this->getHtmlFontsPanel($arrFontsParamNames);
				}
				
				$html .= self::TAB2."</div>";
			}
			
			
			$html .= self::TAB."</div>";	//config table
		}
		
		if($this->view == self::VIEW_COMBINED){
			
			if($this->hasItems == true){
				$html .= self::TAB4."</td>".self::BR;
				
				//end right cell
				
				$html .= self::TAB3."</tr>".self::BR;
				$html .= self::TAB2."</table>".self::BR;
			}else{
				$html .= self::TAB2."</div>".self::BR;	//end config table
			}
			
		}
			
		//end preview table
		$html .= $this->getHtmlPreview();
		
		$html .= self::TAB."</div>".self::BR;	//main wrapper
		
		if($putMode == true)
			echo $html;
		else
			return($html);
	}
	
	
	/**
	 * put html frame
	 */
	public function putHtmlFrame(){
		$this->getHtmlFrame(true);
	}
	
	
	
	/**
	 * set to start with preview
	 */
	public function startWithPreview($isPreview){
		
		$this->isPreviewMode = $isPreview;
	}
	
	
	/**
	 * check tabs view if relevant
	 */
	public function checkTabsView(){
		
		if($this->view == self::VIEW_TABS && $this->hasItems == false)
			$this->view = self::VIEW_COMBINED;
	}
	
	
	/**
	 * set start addon
	 */
	public function setStartAddon(UniteCreatorAddon $objAddon){
		$this->startWithAddon = true;
		
		$this->startAddon = $objAddon;
				
		$this->hasItems = $this->startAddon->isHasItems();
		
		//$this->checkTabsView();
		
	}
	
	
	/**
	 * change view to tabs
	 */
	public function setViewTabs(){
		
		$this->view = self::VIEW_TABS;
		
		//$this->checkTabsView();
	}
	
	
}