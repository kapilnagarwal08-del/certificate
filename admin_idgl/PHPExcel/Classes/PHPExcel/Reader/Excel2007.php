<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Reader
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
    require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}

/**
 * PHPExcel_Reader_Excel2007
 *
 * @category    PHPExcel
 * @package     PHPExcel_Reader
 * @copyright   Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Reader_Excel2007 extends PHPExcel_Reader_Abstract implements PHPExcel_Reader_IReader
{
    /**
     * PHPExcel_ReferenceHelper instance
     *
     * @var PHPExcel_ReferenceHelper
     */
    private $_referenceHelper = null;

    /**
     * PHPExcel_Reader_Excel2007_Theme instance
     *
     * @var PHPExcel_Reader_Excel2007_Theme
     */
    private static $_theme = null;

    /**
     * Create a new PHPExcel_Reader_Excel2007 instance
     */
    public function __construct()
    {
        $this->_readFilter = new PHPExcel_Reader_DefaultReadFilter();
        $this->_referenceHelper = PHPExcel_ReferenceHelper::getInstance();
    }

    /**
     * Can the current PHPExcel_Reader_IReader read the file?
     *
     * @param     string         $pFilename
     * @return     boolean
     * @throws     PHPExcel_Reader_Exception
     */
    public function canRead($pFilename)
    {
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $zipClass = PHPExcel_Settings::getZipClass();
        $xl = false;
        $zip = new $zipClass;
        if ($zip->open($pFilename) === true) {
            $rels = simplexml_load_string(
                $this->securityScan($this->_getFromZipArchive($zip, "_rels/.rels")),
                'SimpleXMLElement',
                PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
            );
            if ($rels !== false) {
                foreach ($rels->Relationship as $rel) {
                    switch ($rel["Type"]) {
                        case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument":
                            if (basename((string)$rel["Target"]) == 'workbook.xml') {
                                $xl = true;
                            }
                            break;
                    }
                }
            }
            $zip->close();
        }

        return $xl;
    }

    /**
     * Reads names of the worksheets from a file, without parsing the whole file to a PHPExcel object
     *
     * @param     string         $pFilename
     * @throws     PHPExcel_Reader_Exception
     */
    public function listWorksheetNames($pFilename)
    {
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $worksheetNames = array();
        $zipClass = PHPExcel_Settings::getZipClass();
        $zip = new $zipClass;
        $zip->open($pFilename);

        $rels = simplexml_load_string(
            $this->securityScan($this->_getFromZipArchive($zip, "_rels/.rels")),
            'SimpleXMLElement',
            PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
        );
        foreach ($rels->Relationship as $rel) {
            switch ($rel["Type"]) {
                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument":
                    $xmlWorkbook = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, (string)$rel['Target'])),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );
                    if ($xmlWorkbook->sheets) {
                        foreach ($xmlWorkbook->sheets->sheet as $eleSheet) {
                            $worksheetNames[] = (string) $eleSheet["name"];
                        }
                    }
            }
        }

        $zip->close();
        return $worksheetNames;
    }

    /**
     * Return worksheet info (Name, Last Column Letter, Last Column Index, Total Rows, Total Columns)
     *
     * @param   string     $pFilename
     * @throws   PHPExcel_Reader_Exception
     */
    public function listWorksheetInfo($pFilename)
    {
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $worksheetInfo = array();
        $zipClass = PHPExcel_Settings::getZipClass();
        $zip = new $zipClass;
        $zip->open($pFilename);

        $rels = simplexml_load_string(
            $this->securityScan($this->_getFromZipArchive($zip, "_rels/.rels")),
            'SimpleXMLElement',
            PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
        );
        foreach ($rels->Relationship as $rel) {
            if ($rel["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument") {
                $dir = dirname((string)$rel["Target"]);
                $relsWorkbook = simplexml_load_string(
                    $this->securityScan($this->_getFromZipArchive($zip, "$dir/_rels/" . basename((string)$rel["Target"]) . ".rels")),
                    'SimpleXMLElement',
                    PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                );
                $relsWorkbook->registerXPathNamespace("rel", "http://schemas.openxmlformats.org/package/2006/relationships");

                $worksheets = array();
                foreach ($relsWorkbook->Relationship as $ele) {
                    if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet") {
                        $worksheets[(string) $ele["Id"]] = $ele["Target"];
                    }
                }

                $xmlWorkbook = simplexml_load_string(
                    $this->securityScan($this->_getFromZipArchive($zip, (string)$rel['Target'])),
                    'SimpleXMLElement',
                    PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                );
                if ($xmlWorkbook->sheets) {
                    $dir = dirname((string)$rel["Target"]);
                    foreach ($xmlWorkbook->sheets->sheet as $eleSheet) {
                        $tmpInfo = array(
                            'worksheetName' => (string) $eleSheet["name"],
                            'lastColumnLetter' => 'A',
                            'lastColumnIndex' => 0,
                            'totalRows' => 0,
                            'totalColumns' => 0,
                        );

                        $fileWorksheet = $worksheets[(string) self::array_item($eleSheet->attributes("http://schemas.openxmlformats.org/officeDocument/2006/relationships"), "id")];

                        $xml = new XMLReader();
                        $res = $xml->xml(
                            $this->securityScanFile('zip://' . PHPExcel_Shared_File::realpath($pFilename) . '#' . "$dir/$fileWorksheet"),
                            null,
                            PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                        );
                        $xml->setParserProperty(2, true);

                        $currCells = 0;
                        while ($xml->read()) {
                            if ($xml->name == 'row' && $xml->nodeType == XMLReader::ELEMENT) {
                                $row = $xml->getAttribute('r');
                                $tmpInfo['totalRows'] = $row;
                                $tmpInfo['totalColumns'] = max($tmpInfo['totalColumns'], $currCells);
                                $currCells = 0;
                            } elseif ($xml->name == 'c' && $xml->nodeType == XMLReader::ELEMENT) {
                                $currCells++;
                            }
                        }
                        $tmpInfo['totalColumns'] = max($tmpInfo['totalColumns'], $currCells);
                        $xml->close();

                        $tmpInfo['lastColumnIndex'] = $tmpInfo['totalColumns'] - 1;
                        $tmpInfo['lastColumnLetter'] = PHPExcel_Cell::stringFromColumnIndex($tmpInfo['lastColumnIndex']);
                        $worksheetInfo[] = $tmpInfo;
                    }
                }
            }
        }

        $zip->close();
        return $worksheetInfo;
    }

    private static function _castToBool($c)
    {
        $value = isset($c->v) ? (string) $c->v : null;
        if ($value == '0') {
            return false;
        } elseif ($value == '1') {
            return true;
        }
        return (bool)$c->v;
    }

    private static function _castToError($c)
    {
        return isset($c->v) ? (string) $c->v : null;
    }

    private static function _castToString($c)
    {
        return isset($c->v) ? (string) $c->v : null;
    }

    private function _castToFormula($c, $r, &$cellDataType, &$value, &$calculatedValue, &$sharedFormulas, $castBaseType)
    {
        $cellDataType = 'f';
        $value = "={$c->f}";
        $calculatedValue = self::$castBaseType($c);

        if (isset($c->f['t']) && strtolower((string)$c->f['t']) == 'shared') {
            $instance = (string)$c->f['si'];
            if (!isset($sharedFormulas[(string)$c->f['si']])) {
                $sharedFormulas[$instance] = array(
                    'master' => $r,
                    'formula' => $value
                );
            } else {
                $master = PHPExcel_Cell::coordinateFromString($sharedFormulas[$instance]['master']);
                $current = PHPExcel_Cell::coordinateFromString($r);

                $difference = array(0, 0);
                $difference[0] = PHPExcel_Cell::columnIndexFromString($current[0]) - PHPExcel_Cell::columnIndexFromString($master[0]);
                $difference[1] = $current[1] - $master[1];

                $value = $this->_referenceHelper->updateFormulaReferences(
                    $sharedFormulas[$instance]['formula'],
                    'A1',
                    $difference[0],
                    $difference[1]
                );
            }
        }
    }

    public function _getFromZipArchive($archive, $fileName = '')
    {
        if (strpos($fileName, '//') !== false) {
            $fileName = substr($fileName, strpos($fileName, '//') + 1);
        }
        $fileName = PHPExcel_Shared_File::realpath($fileName);
        $contents = $archive->getFromName($fileName);
        if ($contents === false) {
            $contents = $archive->getFromName(substr($fileName, 1));
        }
        return $contents;
    }

    /**
     * Loads PHPExcel from file
     *
     * @param     string         $pFilename
     * @return    PHPExcel
     * @throws     PHPExcel_Reader_Exception
     */
    public function load($pFilename)
    {
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $excel = new PHPExcel;
        $excel->removeSheetByIndex(0);
        if (!$this->_readDataOnly) {
            $excel->removeCellStyleXfByIndex(0);
            $excel->removeCellXfByIndex(0);
        }

        $zipClass = PHPExcel_Settings::getZipClass();
        $zip = new $zipClass;
        $zip->open($pFilename);

        $wbRels = simplexml_load_string(
            $this->securityScan($this->_getFromZipArchive($zip, "xl/_rels/workbook.xml.rels")),
            'SimpleXMLElement',
            PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
        );
        foreach ($wbRels->Relationship as $rel) {
            switch ($rel["Type"]) {
                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme":
                    $themeOrderArray = array('lt1', 'dk1', 'lt2', 'dk2');
                    $themeOrderAdditional = count($themeOrderArray);
                    $xmlTheme = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, "xl/{$rel['Target']}")),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );
                    if (is_object($xmlTheme)) {
                        $xmlThemeName = $xmlTheme->attributes();
                        $xmlTheme = $xmlTheme->children("http://schemas.openxmlformats.org/drawingml/2006/main");
                        $themeName = (string)$xmlThemeName['name'];
                        $colourScheme = $xmlTheme->themeElements->clrScheme->attributes();
                        $colourSchemeName = (string)$colourScheme['name'];
                        $colourScheme = $xmlTheme->themeElements->clrScheme->children("http://schemas.openxmlformats.org/drawingml/2006/main");
                        $themeColours = array();
                        foreach ($colourScheme as $k => $xmlColour) {
                            $themePos = array_search($k, $themeOrderArray);
                            if ($themePos === false) {
                                $themePos = $themeOrderAdditional++;
                            }
                            if (isset($xmlColour->sysClr)) {
                                $xmlColourData = $xmlColour->sysClr->attributes();
                                $themeColours[$themePos] = $xmlColourData['lastClr'];
                            } elseif (isset($xmlColour->srgbClr)) {
                                $xmlColourData = $xmlColour->srgbClr->attributes();
                                $themeColours[$themePos] = $xmlColourData['val'];
                            }
                        }
                        self::$_theme = new PHPExcel_Reader_Excel2007_Theme($themeName, $colourSchemeName, $themeColours);
                    }
                    break;
            }
        }

        $rels = simplexml_load_string(
            $this->securityScan($this->_getFromZipArchive($zip, "_rels/.rels")),
            'SimpleXMLElement',
            PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
        );
        foreach ($rels->Relationship as $rel) {
            switch ($rel["Type"]) {
                case "http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties":
                    $xmlCore = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, (string)$rel['Target'])),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );
                    if (is_object($xmlCore)) {
                        $xmlCore->registerXPathNamespace("dc", "http://purl.org/dc/elements/1.1/");
                        $xmlCore->registerXPathNamespace("dcterms", "http://purl.org/dc/terms/");
                        $xmlCore->registerXPathNamespace("cp", "http://schemas.openxmlformats.org/package/2006/metadata/core-properties");
                        $docProps = $excel->getProperties();
                        $docProps->setCreator((string) self::array_item($xmlCore->xpath("dc:creator")));
                        $docProps->setLastModifiedBy((string) self::array_item($xmlCore->xpath("cp:lastModifiedBy")));
                        $docProps->setCreated(strtotime(self::array_item($xmlCore->xpath("dcterms:created"))));
                        $docProps->setModified(strtotime(self::array_item($xmlCore->xpath("dcterms:modified"))));
                        $docProps->setTitle((string) self::array_item($xmlCore->xpath("dc:title")));
                        $docProps->setDescription((string) self::array_item($xmlCore->xpath("dc:description")));
                        $docProps->setSubject((string) self::array_item($xmlCore->xpath("dc:subject")));
                        $docProps->setKeywords((string) self::array_item($xmlCore->xpath("cp:keywords")));
                        $docProps->setCategory((string) self::array_item($xmlCore->xpath("cp:category")));
                    }
                    break;

                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties":
                    $xmlCore = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, (string)$rel['Target'])),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );
                    if (is_object($xmlCore)) {
                        $docProps = $excel->getProperties();
                        if (isset($xmlCore->Company)) {
                            $docProps->setCompany((string) $xmlCore->Company);
                        }
                        if (isset($xmlCore->Manager)) {
                            $docProps->setManager((string) $xmlCore->Manager);
                        }
                    }
                    break;

                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/custom-properties":
                    $xmlCore = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, (string)$rel['Target'])),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );
                    if (is_object($xmlCore)) {
                        $docProps = $excel->getProperties();
                        foreach ($xmlCore as $xmlProperty) {
                            $cellDataOfficeAttributes = $xmlProperty->attributes();
                            if (isset($cellDataOfficeAttributes['name'])) {
                                $propertyName = (string) $cellDataOfficeAttributes['name'];
                                $cellDataOfficeChildren = $xmlProperty->children('http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes');
                                $attributeType = $cellDataOfficeChildren->getName();
                                $attributeValue = (string) $cellDataOfficeChildren->{$attributeType};
                                $attributeValue = PHPExcel_DocumentProperties::convertProperty($attributeValue, $attributeType);
                                $attributeType = PHPExcel_DocumentProperties::convertPropertyType($attributeType);
                                $docProps->setCustomProperty($propertyName, $attributeValue, $attributeType);
                            }
                        }
                    }
                    break;

                case "http://schemas.microsoft.com/office/2006/relationships/ui/extensibility":
                    $customUI = (string)$rel['Target'];
                    if (!is_null($customUI)) {
                        $this->_readRibbon($excel, $customUI, $zip);
                    }
                    break;

                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument":
                    $dir = dirname((string)$rel["Target"]);
                    $relsWorkbook = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, "$dir/_rels/" . basename((string)$rel["Target"]) . ".rels")),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );
                    $relsWorkbook->registerXPathNamespace("rel", "http://schemas.openxmlformats.org/package/2006/relationships");

                    $sharedStrings = array();
                    $xpath = self::array_item($relsWorkbook->xpath("rel:Relationship[@Type='http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings']"));
                    $xmlStrings = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, "$dir/$xpath[Target]")),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );
                    if (isset($xmlStrings) && isset($xmlStrings->si)) {
                        foreach ($xmlStrings->si as $val) {
                            if (isset($val->t)) {
                                $sharedStrings[] = PHPExcel_Shared_String::ControlCharacterOOXML2PHP((string) $val->t);
                            } elseif (isset($val->r)) {
                                $sharedStrings[] = $this->_parseRichText($val);
                            }
                        }
                    }

                    $worksheets = array();
                    $macros = $customUI = null;
                    foreach ($relsWorkbook->Relationship as $ele) {
                        switch ($ele['Type']) {
                            case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet":
                                $worksheets[(string) $ele["Id"]] = $ele["Target"];
                                break;
                            case "http://schemas.microsoft.com/office/2006/relationships/vbaProject":
                                $macros = $ele["Target"];
                                break;
                        }
                    }

                    if (!is_null($macros)) {
                        $macrosCode = $this->_getFromZipArchive($zip, 'xl/vbaProject.bin');
                        if ($macrosCode !== false) {
                            $excel->setMacrosCode($macrosCode);
                            $excel->setHasMacros(true);
                            $Certificate = $this->_getFromZipArchive($zip, 'xl/vbaProjectSignature.bin');
                            if ($Certificate !== false) {
                                $excel->setMacrosCertificate($Certificate);
                            }
                        }
                    }

                    $styles = array();
                    $cellStyles = array();
                    $xpath = self::array_item($relsWorkbook->xpath("rel:Relationship[@Type='http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles']"));
                    $xmlStyles = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, "$dir/$xpath[Target]")),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );
                    $numFmts = null;
                    if ($xmlStyles && $xmlStyles->numFmts[0]) {
                        $numFmts = $xmlStyles->numFmts[0];
                    }
                    if (isset($numFmts) && ($numFmts !== null)) {
                        $numFmts->registerXPathNamespace("sml", "http://schemas.openxmlformats.org/spreadsheetml/2006/main");
                    }
                    if (!$this->_readDataOnly && $xmlStyles) {
                        foreach ($xmlStyles->cellXfs->xf as $xf) {
                            $numFmt = PHPExcel_Style_NumberFormat::FORMAT_GENERAL;
                            if ($xf["numFmtId"]) {
                                if (isset($numFmts)) {
                                    $tmpNumFmt = self::array_item($numFmts->xpath("sml:numFmt[@numFmtId=$xf[numFmtId]]"));
                                    if (isset($tmpNumFmt["formatCode"])) {
                                        $numFmt = (string) $tmpNumFmt["formatCode"];
                                    }
                                }
                                if ((int)$xf["numFmtId"] < 164) {
                                    $numFmt = PHPExcel_Style_NumberFormat::builtInFormatCode((int)$xf["numFmtId"]);
                                }
                            }
                            $quotePrefix = false;
                            if (isset($xf["quotePrefix"])) {
                                $quotePrefix = (boolean) $xf["quotePrefix"];
                            }
                            $style = (object) array(
                                "numFmt" => $numFmt,
                                "font" => $xmlStyles->fonts->font[intval($xf["fontId"])],
                                "fill" => $xmlStyles->fills->fill[intval($xf["fillId"])],
                                "border" => $xmlStyles->borders->border[intval($xf["borderId"])],
                                "alignment" => $xf->alignment,
                                "protection" => $xf->protection,
                                "quotePrefix" => $quotePrefix,
                            );
                            $styles[] = $style;

                            $objStyle = new PHPExcel_Style;
                            self::_readStyle($objStyle, $style);
                            $excel->addCellXf($objStyle);
                        }

                        foreach ($xmlStyles->cellStyleXfs->xf as $xf) {
                            $numFmt = PHPExcel_Style_NumberFormat::FORMAT_GENERAL;
                            if ($numFmts && $xf["numFmtId"]) {
                                $tmpNumFmt = self::array_item($numFmts->xpath("sml:numFmt[@numFmtId=$xf[numFmtId]]"));
                                if (isset($tmpNumFmt["formatCode"])) {
                                    $numFmt = (string) $tmpNumFmt["formatCode"];
                                } elseif ((int)$xf["numFmtId"] < 165) {
                                    $numFmt = PHPExcel_Style_NumberFormat::builtInFormatCode((int)$xf["numFmtId"]);
                                }
                            }
                            $cellStyle = (object) array(
                                "numFmt" => $numFmt,
                                "font" => $xmlStyles->fonts->font[intval($xf["fontId"])],
                                "fill" => $xmlStyles->fills->fill[intval($xf["fillId"])],
                                "border" => $xmlStyles->borders->border[intval($xf["borderId"])],
                                "alignment" => $xf->alignment,
                                "protection" => $xf->protection,
                                "quotePrefix" => $quotePrefix,
                            );
                            $cellStyles[] = $cellStyle;

                            $objStyle = new PHPExcel_Style;
                            self::_readStyle($objStyle, $cellStyle);
                            $excel->addCellStyleXf($objStyle);
                        }
                    }

                    $dxfs = array();
                    if (!$this->_readDataOnly && $xmlStyles) {
                        if ($xmlStyles->dxfs) {
                            foreach ($xmlStyles->dxfs->dxf as $dxf) {
                                $style = new PHPExcel_Style(false, true);
                                self::_readStyle($style, $dxf);
                                $dxfs[] = $style;
                            }
                        }
                        if ($xmlStyles->cellStyles) {
                            foreach ($xmlStyles->cellStyles->cellStyle as $cellStyle) {
                                if (intval($cellStyle['builtinId']) == 0) {
                                    if (isset($cellStyles[intval($cellStyle['xfId'])])) {
                                        $style = new PHPExcel_Style;
                                        self::_readStyle($style, $cellStyles[intval($cellStyle['xfId'])]);
                                    }
                                }
                            }
                        }
                    }

                    $xmlWorkbook = simplexml_load_string(
                        $this->securityScan($this->_getFromZipArchive($zip, (string)$rel['Target'])),
                        'SimpleXMLElement',
                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                    );

                    if ($xmlWorkbook->workbookPr) {
                        PHPExcel_Shared_Date::setExcelCalendar(PHPExcel_Shared_Date::CALENDAR_WINDOWS_1900);
                        if (isset($xmlWorkbook->workbookPr['date1904'])) {
                            if (self::boolean((string) $xmlWorkbook->workbookPr['date1904'])) {
                                PHPExcel_Shared_Date::setExcelCalendar(PHPExcel_Shared_Date::CALENDAR_MAC_1904);
                            }
                        }
                    }

                    $sheetId = 0;
                    $oldSheetId = -1;
                    $countSkippedSheets = 0;
                    $mapSheetId = array();
                    $charts = $chartDetails = array();

                    if ($xmlWorkbook->sheets) {
                        foreach ($xmlWorkbook->sheets->sheet as $eleSheet) {
                            ++$oldSheetId;
                            if (isset($this->_loadSheetsOnly) && !in_array((string) $eleSheet["name"], $this->_loadSheetsOnly)) {
                                ++$countSkippedSheets;
                                $mapSheetId[$oldSheetId] = null;
                                continue;
                            }

                            $mapSheetId[$oldSheetId] = $oldSheetId - $countSkippedSheets;
                            $docSheet = $excel->createSheet();
                            $docSheet->setTitle((string) $eleSheet["name"], false);
                            $fileWorksheet = $worksheets[(string) self::array_item($eleSheet->attributes("http://schemas.openxmlformats.org/officeDocument/2006/relationships"), "id")];
                            $xmlSheet = simplexml_load_string(
                                $this->securityScan($this->_getFromZipArchive($zip, "$dir/$fileWorksheet")),
                                'SimpleXMLElement',
                                PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                            );

                            $sharedFormulas = array();
                            if (isset($eleSheet["state"]) && (string) $eleSheet["state"] != '') {
                                $docSheet->setSheetState((string) $eleSheet["state"]);
                            }

                            if (isset($xmlSheet->sheetViews) && isset($xmlSheet->sheetViews->sheetView)) {
                                if (isset($xmlSheet->sheetViews->sheetView['zoomScale'])) {
                                    $docSheet->getSheetView()->setZoomScale(intval($xmlSheet->sheetViews->sheetView['zoomScale']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['zoomScaleNormal'])) {
                                    $docSheet->getSheetView()->setZoomScaleNormal(intval($xmlSheet->sheetViews->sheetView['zoomScaleNormal']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['view'])) {
                                    $docSheet->getSheetView()->setView((string) $xmlSheet->sheetViews->sheetView['view']);
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['showGridLines'])) {
                                    $docSheet->setShowGridLines(self::boolean((string)$xmlSheet->sheetViews->sheetView['showGridLines']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['showRowColHeaders'])) {
                                    $docSheet->setShowRowColHeaders(self::boolean((string)$xmlSheet->sheetViews->sheetView['showRowColHeaders']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['rightToLeft'])) {
                                    $docSheet->setRightToLeft(self::boolean((string)$xmlSheet->sheetViews->sheetView['rightToLeft']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView->pane)) {
                                    if (isset($xmlSheet->sheetViews->sheetView->pane['topLeftCell'])) {
                                        $docSheet->freezePane((string)$xmlSheet->sheetViews->sheetView->pane['topLeftCell']);
                                    } else {
                                        $xSplit = 0;
                                        $ySplit = 0;
                                        if (isset($xmlSheet->sheetViews->sheetView->pane['xSplit'])) {
                                            $xSplit = 1 + intval($xmlSheet->sheetViews->sheetView->pane['xSplit']);
                                        }
                                        if (isset($xmlSheet->sheetViews->sheetView->pane['ySplit'])) {
                                            $ySplit = 1 + intval($xmlSheet->sheetViews->sheetView->pane['ySplit']);
                                        }
                                        $docSheet->freezePaneByColumnAndRow($xSplit, $ySplit);
                                    }
                                }
                                if (isset($xmlSheet->sheetViews->sheetView->selection)) {
                                    if (isset($xmlSheet->sheetViews->sheetView->selection['sqref'])) {
                                        $sqref = (string)$xmlSheet->sheetViews->sheetView->selection['sqref'];
                                        $sqref = explode(' ', $sqref);
                                        $sqref = $sqref[0];
                                        $docSheet->setSelectedCells($sqref);
                                    }
                                }
                            }

                            if (isset($xmlSheet->sheetPr) && isset($xmlSheet->sheetPr->tabColor)) {
                                if (isset($xmlSheet->sheetPr->tabColor['rgb'])) {
                                    $docSheet->getTabColor()->setARGB((string)$xmlSheet->sheetPr->tabColor['rgb']);
                                }
                            }
                            if (isset($xmlSheet->sheetPr) && isset($xmlSheet->sheetPr['codeName'])) {
                                $docSheet->setCodeName((string) $xmlSheet->sheetPr['codeName']);
                            }
                            if (isset($xmlSheet->sheetPr) && isset($xmlSheet->sheetPr->outlinePr)) {
                                if (isset($xmlSheet->sheetPr->outlinePr['summaryRight']) &&
                                    !self::boolean((string) $xmlSheet->sheetPr->outlinePr['summaryRight'])) {
                                    $docSheet->setShowSummaryRight(false);
                                } else {
                                    $docSheet->setShowSummaryRight(true);
                                }
                                if (isset($xmlSheet->sheetPr->outlinePr['summaryBelow']) &&
                                    !self::boolean((string) $xmlSheet->sheetPr->outlinePr['summaryBelow'])) {
                                    $docSheet->setShowSummaryBelow(false);
                                } else {
                                    $docSheet->setShowSummaryBelow(true);
                                }
                            }

                            if (isset($xmlSheet->sheetPr) && isset($xmlSheet->sheetPr->pageSetUpPr)) {
                                if (isset($xmlSheet->sheetPr->pageSetUpPr['fitToPage']) &&
                                    !self::boolean((string) $xmlSheet->sheetPr->pageSetUpPr['fitToPage'])) {
                                    $docSheet->getPageSetup()->setFitToPage(false);
                                } else {
                                    $docSheet->getPageSetup()->setFitToPage(true);
                                }
                            }

                            if (isset($xmlSheet->sheetFormatPr)) {
                                if (isset($xmlSheet->sheetFormatPr['customHeight']) &&
                                    self::boolean((string) $xmlSheet->sheetFormatPr['customHeight']) &&
                                    isset($xmlSheet->sheetFormatPr['defaultRowHeight'])) {
                                    $docSheet->getDefaultRowDimension()->setRowHeight((float)$xmlSheet->sheetFormatPr['defaultRowHeight']);
                                }
                                if (isset($xmlSheet->sheetFormatPr['defaultColWidth'])) {
                                    $docSheet->getDefaultColumnDimension()->setWidth((float)$xmlSheet->sheetFormatPr['defaultColWidth']);
                                }
                                if (isset($xmlSheet->sheetFormatPr['zeroHeight']) &&
                                    ((string)$xmlSheet->sheetFormatPr['zeroHeight'] == '1')) {
                                    $docSheet->getDefaultRowDimension()->setZeroHeight(true);
                                }
                            }

                            if (isset($xmlSheet->cols) && !$this->_readDataOnly) {
                                foreach ($xmlSheet->cols->col as $col) {
                                    for ($i = intval($col["min"]) - 1; $i < intval($col["max"]); ++$i) {
                                        if ($col["style"] && !$this->_readDataOnly) {
                                            $docSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setXfIndex(intval($col["style"]));
                                        }
                                        if (self::boolean($col["bestFit"])) {
                                            $docSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);
                                        }
                                        if (self::boolean($col["hidden"])) {
                                            $docSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setVisible(false);
                                        }
                                        if (self::boolean($col["collapsed"])) {
                                            $docSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setCollapsed(true);
                                        }
                                        if ($col["outlineLevel"] > 0) {
                                            $docSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setOutlineLevel(intval($col["outlineLevel"]));
                                        }
                                        $docSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setWidth(floatval($col["width"]));
                                        if (intval($col["max"]) == 16384) {
                                            break;
                                        }
                                    }
                                }
                            }

                            if (isset($xmlSheet->printOptions) && !$this->_readDataOnly) {
                                if (self::boolean((string) $xmlSheet->printOptions['gridLinesSet'])) {
                                    $docSheet->setShowGridlines(true);
                                }
                                if (self::boolean((string) $xmlSheet->printOptions['gridLines'])) {
                                    $docSheet->setPrintGridlines(true);
                                }
                                if (self::boolean((string) $xmlSheet->printOptions['horizontalCentered'])) {
                                    $docSheet->getPageSetup()->setHorizontalCentered(true);
                                }
                                if (self::boolean((string) $xmlSheet->printOptions['verticalCentered'])) {
                                    $docSheet->getPageSetup()->setVerticalCentered(true);
                                }
                            }

                            if ($xmlSheet && $xmlSheet->sheetData && $xmlSheet->sheetData->row) {
                                foreach ($xmlSheet->sheetData->row as $row) {
                                    if ($row["ht"] && !$this->_readDataOnly) {
                                        $docSheet->getRowDimension(intval($row["r"]))->setRowHeight(floatval($row["ht"]));
                                    }
                                    if (self::boolean($row["hidden"]) && !$this->_readDataOnly) {
                                        $docSheet->getRowDimension(intval($row["r"]))->setVisible(false);
                                    }
                                    if (self::boolean($row["collapsed"])) {
                                        $docSheet->getRowDimension(intval($row["r"]))->setCollapsed(true);
                                    }
                                    if ($row["outlineLevel"] > 0) {
                                        $docSheet->getRowDimension(intval($row["r"]))->setOutlineLevel(intval($row["outlineLevel"]));
                                    }
                                    if ($row["s"] && !$this->_readDataOnly) {
                                        $docSheet->getRowDimension(intval($row["r"]))->setXfIndex(intval($row["s"]));
                                    }

                                    foreach ($row->c as $c) {
                                        $r = (string) $c["r"];
                                        $cellDataType = (string) $c["t"];
                                        $value = null;
                                        $calculatedValue = null;

                                        if ($this->getReadFilter() !== null) {
                                            $coordinates = PHPExcel_Cell::coordinateFromString($r);
                                            if (!$this->getReadFilter()->readCell($coordinates[0], $coordinates[1], $docSheet->getTitle())) {
                                                continue;
                                            }
                                        }

                                        switch ($cellDataType) {
                                            case "s":
                                                if ((string)$c->v != '') {
                                                    $value = $sharedStrings[intval($c->v)];
                                                    if ($value instanceof PHPExcel_RichText) {
                                                        $value = clone $value;
                                                    }
                                                } else {
                                                    $value = '';
                                                }
                                                break;
                                            case "b":
                                                if (!isset($c->f)) {
                                                    $value = self::_castToBool($c);
                                                } else {
                                                    $this->_castToFormula($c, $r, $cellDataType, $value, $calculatedValue, $sharedFormulas, '_castToBool');
                                                    if (isset($c->f['t'])) {
                                                        $att = $c->f;
                                                        $docSheet->getCell($r)->setFormulaAttributes($att);
                                                    }
                                                }
                                                break;
                                            case "inlineStr":
                                                $value = $this->_parseRichText($c->is);
                                                break;
                                            case "e":
                                                if (!isset($c->f)) {
                                                    $value = self::_castToError($c);
                                                } else {
                                                    $this->_castToFormula($c, $r, $cellDataType, $value, $calculatedValue, $sharedFormulas, '_castToError');
                                                }
                                                break;
                                            default:
                                                if (!isset($c->f)) {
                                                    $value = self::_castToString($c);
                                                } else {
                                                    $this->_castToFormula($c, $r, $cellDataType, $value, $calculatedValue, $sharedFormulas, '_castToString');
                                                }
                                                break;
                                        }

                                        if (is_numeric($value) && $cellDataType != 's') {
                                            if ($value == (int)$value) {
                                                $value = (int)$value;
                                            } elseif ($value == (float)$value) {
                                                $value = (float)$value;
                                            } elseif ($value == (double)$value) {
                                                $value = (double)$value;
                                            }
                                        }

                                        if ($value instanceof PHPExcel_RichText && $this->_readDataOnly) {
                                            $value = $value->getPlainText();
                                        }

                                        $cell = $docSheet->getCell($r);
                                        if ($cellDataType != '') {
                                            $cell->setValueExplicit($value, $cellDataType);
                                        } else {
                                            $cell->setValue($value);
                                        }
                                        if ($calculatedValue !== null) {
                                            $cell->setCalculatedValue($calculatedValue);
                                        }

                                        if ($c["s"] && !$this->_readDataOnly) {
                                            $cell->setXfIndex(isset($styles[intval($c["s"])]) ? intval($c["s"]) : 0);
                                        }
                                    }
                                }
                            }

                            $conditionals = array();
                            if (!$this->_readDataOnly && $xmlSheet && $xmlSheet->conditionalFormatting) {
                                foreach ($xmlSheet->conditionalFormatting as $conditional) {
                                    foreach ($conditional->cfRule as $cfRule) {
                                        if (
                                            (
                                                (string)$cfRule["type"] == PHPExcel_Style_Conditional::CONDITION_NONE ||
                                                (string)$cfRule["type"] == PHPExcel_Style_Conditional::CONDITION_CELLIS ||
                                                (string)$cfRule["type"] == PHPExcel_Style_Conditional::CONDITION_CONTAINSTEXT ||
                                                (string)$cfRule["type"] == PHPExcel_Style_Conditional::CONDITION_EXPRESSION
                                            ) && isset($dxfs[intval($cfRule["dxfId"])])
                                        ) {
                                            $conditionals[(string) $conditional["sqref"]][intval($cfRule["priority"])] = $cfRule;
                                        }
                                    }
                                }

                                foreach ($conditionals as $ref => $cfRules) {
                                    ksort($cfRules);
                                    $conditionalStyles = array();
                                    foreach ($cfRules as $cfRule) {
                                        $objConditional = new PHPExcel_Style_Conditional();
                                        $objConditional->setConditionType((string)$cfRule["type"]);
                                        $objConditional->setOperatorType((string)$cfRule["operator"]);
                                        if ((string)$cfRule["text"] != '') {
                                            $objConditional->setText((string)$cfRule["text"]);
                                        }
                                        if (count($cfRule->formula) > 1) {
                                            foreach ($cfRule->formula as $formula) {
                                                $objConditional->addCondition((string)$formula);
                                            }
                                        } else {
                                            $objConditional->addCondition((string)$cfRule->formula);
                                        }
                                        $objConditional->setStyle(clone $dxfs[intval($cfRule["dxfId"])]);
                                        $conditionalStyles[] = $objConditional;
                                    }

                                    $aReferences = PHPExcel_Cell::extractAllCellReferencesInRange($ref);
                                    foreach ($aReferences as $reference) {
                                        $docSheet->getStyle($reference)->setConditionalStyles($conditionalStyles);
                                    }
                                }
                            }

                            $aKeys = array("sheet", "objects", "scenarios", "formatCells", "formatColumns", "formatRows", "insertColumns", "insertRows", "insertHyperlinks", "deleteColumns", "deleteRows", "selectLockedCells", "sort", "autoFilter", "pivotTables", "selectUnlockedCells");
                            if (!$this->_readDataOnly && $xmlSheet && $xmlSheet->sheetProtection) {
                                foreach ($aKeys as $key) {
                                    $method = "set" . ucfirst($key);
                                    $docSheet->getProtection()->$method(self::boolean((string) $xmlSheet->sheetProtection[$key]));
                                }
                            }

                            if (!$this->_readDataOnly && $xmlSheet && $xmlSheet->sheetProtection) {
                                $docSheet->getProtection()->setPassword((string) $xmlSheet->sheetProtection["password"], true);
                                if ($xmlSheet->protectedRanges->protectedRange) {
                                    foreach ($xmlSheet->protectedRanges->protectedRange as $protectedRange) {
                                        $docSheet->protectCells((string) $protectedRange["sqref"], (string) $protectedRange["password"], true);
                                    }
                                }
                            }

                            if ($xmlSheet && $xmlSheet->autoFilter && !$this->_readDataOnly) {
                                $autoFilterRange = (string) $xmlSheet->autoFilter["ref"];
                                if (strpos($autoFilterRange, ':') !== false) {
                                    $autoFilter = $docSheet->getAutoFilter();
                                    $autoFilter->setRange($autoFilterRange);
                                    foreach ($xmlSheet->autoFilter->filterColumn as $filterColumn) {
                                        $column = $autoFilter->getColumnByOffset((integer) $filterColumn["colId"]);
                                        if ($filterColumn->filters) {
                                            $column->setFilterType(PHPExcel_Worksheet_AutoFilter_Column::AUTOFILTER_FILTERTYPE_FILTER);
                                            $filters = $filterColumn->filters;
                                            if ((isset($filters["blank"])) && ($filters["blank"] == 1)) {
                                                $column->createRule()->setRule(null, '')->setRuleType(PHPExcel_Worksheet_AutoFilter_Column_Rule::AUTOFILTER_RULETYPE_FILTER);
                                            }
                                            foreach ($filters->filter as $filterRule) {
                                                $column->createRule()->setRule(null, (string) $filterRule["val"])->setRuleType(PHPExcel_Worksheet_AutoFilter_Column_Rule::AUTOFILTER_RULETYPE_FILTER);
                                            }
                                            foreach ($filters->dateGroupItem as $dateGroupItem) {
                                                $column->createRule()->setRule(
                                                    null,
                                                    array(
                                                        'year' => (string) $dateGroupItem["year"],
                                                        'month' => (string) $dateGroupItem["month"],
                                                        'day' => (string) $dateGroupItem["day"],
                                                        'hour' => (string) $dateGroupItem["hour"],
                                                        'minute' => (string) $dateGroupItem["minute"],
                                                        'second' => (string) $dateGroupItem["second"],
                                                    ),
                                                    (string) $dateGroupItem["dateTimeGrouping"]
                                                )->setRuleType(PHPExcel_Worksheet_AutoFilter_Column_Rule::AUTOFILTER_RULETYPE_DATEGROUP);
                                            }
                                        }
                                        if ($filterColumn->customFilters) {
                                            $column->setFilterType(PHPExcel_Worksheet_AutoFilter_Column::AUTOFILTER_FILTERTYPE_CUSTOMFILTER);
                                            $customFilters = $filterColumn->customFilters;
                                            if ((isset($customFilters["and"])) && ($customFilters["and"] == 1)) {
                                                $column->setJoin(PHPExcel_Worksheet_AutoFilter_Column::AUTOFILTER_COLUMN_JOIN_AND);
                                            }
                                            foreach ($customFilters->customFilter as $filterRule) {
                                                $column->createRule()->setRule(
                                                    (string) $filterRule["operator"],
                                                    (string) $filterRule["val"]
                                                )->setRuleType(PHPExcel_Worksheet_AutoFilter_Column_Rule::AUTOFILTER_RULETYPE_CUSTOMFILTER);
                                            }
                                        }
                                    }
                                }
                            }

                            if (!$this->_readDataOnly) {
                                if ($zip->locateName(dirname("$dir/$fileWorksheet") . "/_rels/" . basename($fileWorksheet) . ".rels")) {
                                    $relsWorksheet = simplexml_load_string(
                                        $this->securityScan($this->_getFromZipArchive($zip, dirname("$dir/$fileWorksheet") . "/_rels/" . basename($fileWorksheet) . ".rels")),
                                        'SimpleXMLElement',
                                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                    );
                                    $hyperlinks = array();
                                    foreach ($relsWorksheet->Relationship as $ele) {
                                        if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink") {
                                            $hyperlinks[(string)$ele["Id"]] = (string)$ele["Target"];
                                        }
                                    }

                                    if ($xmlSheet && $xmlSheet->hyperlinks) {
                                        foreach ($xmlSheet->hyperlinks->hyperlink as $hyperlink) {
                                            $linkRel = $hyperlink->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships');
                                            foreach (PHPExcel_Cell::extractAllCellReferencesInRange($hyperlink['ref']) as $cellReference) {
                                                $cell = $docSheet->getCell($cellReference);
                                                if (isset($linkRel['id'])) {
                                                    $hyperlinkUrl = $hyperlinks[(string)$linkRel['id']];
                                                    if (isset($hyperlink['location'])) {
                                                        $hyperlinkUrl .= '#' . (string) $hyperlink['location'];
                                                    }
                                                    $cell->getHyperlink()->setUrl($hyperlinkUrl);
                                                } elseif (isset($hyperlink['location'])) {
                                                    $cell->getHyperlink()->setUrl('sheet://' . (string)$hyperlink['location']);
                                                }
                                                if (isset($hyperlink['tooltip'])) {
                                                    $cell->getHyperlink()->setTooltip((string) $hyperlink['tooltip']);
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            $comments = array();
                            $vmlComments = array();
                            if (!$this->_readDataOnly) {
                                if ($zip->locateName(dirname("$dir/$fileWorksheet") . "/_rels/" . basename($fileWorksheet) . ".rels")) {
                                    $relsWorksheet = simplexml_load_string(
                                        $this->securityScan($this->_getFromZipArchive($zip, dirname("$dir/$fileWorksheet") . "/_rels/" . basename($fileWorksheet) . ".rels")),
                                        'SimpleXMLElement',
                                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                    );
                                    foreach ($relsWorksheet->Relationship as $ele) {
                                        if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/comments") {
                                            $comments[(string)$ele["Id"]] = (string)$ele["Target"];
                                        }
                                        if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/vmlDrawing") {
                                            $vmlComments[(string)$ele["Id"]] = (string)$ele["Target"];
                                        }
                                    }
                                }

                                foreach ($comments as $relName => $relPath) {
                                    $relPath = PHPExcel_Shared_File::realpath(dirname("$dir/$fileWorksheet") . "/" . $relPath);
                                    $commentsFile = simplexml_load_string(
                                        $this->securityScan($this->_getFromZipArchive($zip, $relPath)),
                                        'SimpleXMLElement',
                                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                    );

                                    $authors = array();
                                    foreach ($commentsFile->authors->author as $author) {
                                        $authors[] = (string)$author;
                                    }

                                    foreach ($commentsFile->commentList->comment as $comment) {
                                        if (!empty($comment['authorId'])) {
                                            $docSheet->getComment((string)$comment['ref'])->setAuthor($authors[(string)$comment['authorId']]);
                                        }
                                        $docSheet->getComment((string)$comment['ref'])->setText($this->_parseRichText($comment->text));
                                    }
                                }

                                foreach ($vmlComments as $relName => $relPath) {
                                    $relPath = PHPExcel_Shared_File::realpath(dirname("$dir/$fileWorksheet") . "/" . $relPath);
                                    $vmlCommentsFile = simplexml_load_string(
                                        $this->securityScan($this->_getFromZipArchive($zip, $relPath)),
                                        'SimpleXMLElement',
                                        PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                    );
                                    $vmlCommentsFile->registerXPathNamespace('v', 'urn:schemas-microsoft-com:vml');

                                    $shapes = $vmlCommentsFile->xpath('//v:shape');
                                    foreach ($shapes as $shape) {
                                        $shape->registerXPathNamespace('v', 'urn:schemas-microsoft-com:vml');
                                        if (isset($shape['style'])) {
                                            $style = (string)$shape['style'];
                                            $fillColor = strtoupper(substr((string)$shape['fillcolor'], 1));
                                            $column = null;
                                            $row = null;

                                            $clientData = $shape->xpath('.//x:ClientData');
                                            if (is_array($clientData) && !empty($clientData)) {
                                                $clientData = $clientData[0];
                                                if (isset($clientData['ObjectType']) && (string)$clientData['ObjectType'] == 'Note') {
                                                    $temp = $clientData->xpath('.//x:Row');
                                                    if (is_array($temp)) $row = $temp[0];
                                                    $temp = $clientData->xpath('.//x:Column');
                                                    if (is_array($temp)) $column = $temp[0];
                                                }
                                            }

                                            if (($column !== null) && ($row !== null)) {
                                                $comment = $docSheet->getCommentByColumnAndRow((string) $column, $row + 1);
                                                $comment->getFillColor()->setRGB($fillColor);
                                                $styleArray = explode(';', str_replace(' ', '', $style));
                                                foreach ($styleArray as $stylePair) {
                                                    $stylePair = explode(':', $stylePair);
                                                    if ($stylePair[0] == 'margin-left') $comment->setMarginLeft($stylePair[1]);
                                                    if ($stylePair[0] == 'margin-top') $comment->setMarginTop($stylePair[1]);
                                                    if ($stylePair[0] == 'width') $comment->setWidth($stylePair[1]);
                                                    if ($stylePair[0] == 'height') $comment->setHeight($stylePair[1]);
                                                    if ($stylePair[0] == 'visibility') $comment->setVisible($stylePair[1] == 'visible');
                                                }
                                            }
                                        }
                                    }
                                }

                                if ($xmlSheet && $xmlSheet->legacyDrawingHF && !$this->_readDataOnly) {
                                    if ($zip->locateName(dirname("$dir/$fileWorksheet") . "/_rels/" . basename($fileWorksheet) . ".rels")) {
                                        $relsWorksheet = simplexml_load_string(
                                            $this->securityScan($this->_getFromZipArchive($zip, dirname("$dir/$fileWorksheet") . "/_rels/" . basename($fileWorksheet) . ".rels")),
                                            'SimpleXMLElement',
                                            PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                        );
                                        $vmlRelationship = '';
                                        foreach ($relsWorksheet->Relationship as $ele) {
                                            if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/vmlDrawing") {
                                                $vmlRelationship = self::dir_add("$dir/$fileWorksheet", $ele["Target"]);
                                            }
                                        }

                                        if ($vmlRelationship != '') {
                                            $relsVML = simplexml_load_string(
                                                $this->securityScan($this->_getFromZipArchive($zip, dirname($vmlRelationship) . '/_rels/' . basename($vmlRelationship) . '.rels')),
                                                'SimpleXMLElement',
                                                PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                            );
                                            $drawings = array();
                                            foreach ($relsVML->Relationship as $ele) {
                                                if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/image") {
                                                    $drawings[(string) $ele["Id"]] = self::dir_add($vmlRelationship, $ele["Target"]);
                                                }
                                            }

                                            $vmlDrawing = simplexml_load_string(
                                                $this->securityScan($this->_getFromZipArchive($zip, $vmlRelationship)),
                                                'SimpleXMLElement',
                                                PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                            );
                                            $vmlDrawing->registerXPathNamespace('v', 'urn:schemas-microsoft-com:vml');
                                            $hfImages = array();
                                            $shapes = $vmlDrawing->xpath('//v:shape');
                                            foreach ($shapes as $idx => $shape) {
                                                $shape->registerXPathNamespace('v', 'urn:schemas-microsoft-com:vml');
                                                $imageData = $shape->xpath('//v:imagedata');
                                                $imageData = $imageData[$idx];
                                                $imageData = $imageData->attributes('urn:schemas-microsoft-com:office:office');
                                                $style = self::toCSSArray((string)$shape['style']);
                                                $hfImages[(string)$shape['id']] = new PHPExcel_Worksheet_HeaderFooterDrawing();
                                                if (isset($imageData['title'])) {
                                                    $hfImages[(string)$shape['id']]->setName((string)$imageData['title']);
                                                }
                                                $hfImages[(string)$shape['id']]->setPath("zip://" . PHPExcel_Shared_File::realpath($pFilename) . "#" . $drawings[(string)$imageData['relid']], false);
                                                $hfImages[(string)$shape['id']]->setResizeProportional(false);
                                                $hfImages[(string)$shape['id']]->setWidth($style['width']);
                                                $hfImages[(string)$shape['id']]->setHeight($style['height']);
                                                if (isset($style['margin-left'])) {
                                                    $hfImages[(string)$shape['id']]->setOffsetX($style['margin-left']);
                                                }
                                                $hfImages[(string)$shape['id']]->setOffsetY($style['margin-top']);
                                                $hfImages[(string)$shape['id']]->setResizeProportional(true);
                                            }
                                            $docSheet->getHeaderFooter()->setImages($hfImages);
                                        }
                                    }
                                }
                            }

                            if ($zip->locateName(dirname("$dir/$fileWorksheet") . "/_rels/" . basename($fileWorksheet) . ".rels")) {
                                $relsWorksheet = simplexml_load_string(
                                    $this->securityScan($this->_getFromZipArchive($zip, dirname("$dir/$fileWorksheet") . "/_rels/" . basename($fileWorksheet) . ".rels")),
                                    'SimpleXMLElement',
                                    PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                );
                                $drawings = array();
                                foreach ($relsWorksheet->Relationship as $ele) {
                                    if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/drawing") {
                                        $drawings[(string) $ele["Id"]] = self::dir_add("$dir/$fileWorksheet", $ele["Target"]);
                                    }
                                }
                                if ($xmlSheet->drawing && !$this->_readDataOnly) {
                                    foreach ($xmlSheet->drawing as $drawing) {
                                        $fileDrawing = $drawings[(string) self::array_item($drawing->attributes("http://schemas.openxmlformats.org/officeDocument/2006/relationships"), "id")];
                                        $relsDrawing = simplexml_load_string(
                                            $this->securityScan($this->_getFromZipArchive($zip, dirname($fileDrawing) . "/_rels/" . basename($fileDrawing) . ".rels")),
                                            'SimpleXMLElement',
                                            PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                        );
                                        $images = array();
                                        if ($relsDrawing && $relsDrawing->Relationship) {
                                            foreach ($relsDrawing->Relationship as $ele) {
                                                if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/image") {
                                                    $images[(string) $ele["Id"]] = self::dir_add($fileDrawing, $ele["Target"]);
                                                } elseif ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/chart") {
                                                    if ($this->_includeCharts) {
                                                        $charts[self::dir_add($fileDrawing, $ele["Target"])] = array(
                                                            'id' => (string) $ele["Id"],
                                                            'sheet' => $docSheet->getTitle()
                                                        );
                                                    }
                                                }
                                            }
                                        }
                                        $xmlDrawing = simplexml_load_string(
                                            $this->securityScan($this->_getFromZipArchive($zip, $fileDrawing)),
                                            'SimpleXMLElement',
                                            PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
                                        )->children("http://schemas.openxmlformats.org/drawingml/2006/spreadsheetDrawing");

                                        if ($xmlDrawing->oneCellAnchor) {
                                            foreach ($xmlDrawing->oneCellAnchor as $oneCellAnchor) {
                                                if ($oneCellAnchor->pic->blipFill) {
                                                    $blip = $oneCellAnchor->pic->blipFill->children("http://schemas.openxmlformats.org/drawingml/2006/main")->blip;
                                                    $xfrm = $oneCellAnchor->pic->spPr->children("http://schemas.openxmlformats.org/drawingml/2006/main")->xfrm;
                                                    $outerShdw = $oneCellAnchor->pic->spPr->children("http://schemas.openxmlformats.org/drawingml/2006/main")->effectLst->outerShdw;
                                                    $objDrawing = new PHPExcel_Worksheet_Drawing;
                                                    $objDrawing->setName((string) self::array_item($oneCellAnchor->pic->nvPicPr->cNvPr->attributes(), "name"));
                                                    $objDrawing->setDescription((string) self::array_item($oneCellAnchor->pic->nvPicPr->cNvPr->attributes(), "descr"));
                                                    $objDrawing->setPath("zip://" . PHPExcel_Shared_File::realpath($pFilename) . "#" . $images[(string) self::array_item($blip->attributes("http://schemas.openxmlformats.org/officeDocument/2006/relationships"), "embed")], false);
                                                    $objDrawing->setCoordinates(PHPExcel_Cell::stringFromColumnIndex((string) $oneCellAnchor->from->col) . ($oneCellAnchor->from->row + 1));
                                                    $objDrawing->setOffsetX(PHPExcel_Shared_Drawing::EMUToPixels($oneCellAnchor->from->colOff));
                                                    $objDrawing->setOffsetY(PHPExcel_Shared_Drawing::EMUToPixels($oneCellAnchor->from->rowOff));
                                                    $objDrawing->setResizeProportional(false);
                                                    $objDrawing->setWidth(PHPExcel_Shared_Drawing::EMUToPixels(self::array_item($oneCellAnchor->ext->attributes(), "cx")));
                                                    $objDrawing->setHeight(PHPExcel_Shared_Drawing::EMUToPixels(self::array_item($oneCellAnchor->ext->attributes(), "cy")));
                                                    if ($xfrm) {
                                                        $objDrawing->setRotation(PHPExcel_Shared_Drawing::angleToDegrees(self::array_item($xfrm->attributes(), "rot")));
                                                    }
                                                    if ($outerShdw) {
                                                        $shadow = $objDrawing->getShadow();
                                                        $shadow->setVisible(true);
                                                        $shadow->setBlurRadius(PHPExcel_Shared_Drawing::EMUTopixels(self::array_item($outerShdw->attributes(), "blurRad")));
                                                        $shadow->setDistance(PHPExcel_Shared_Drawing::EMUTopixels(self::array_item($outerShdw->attributes(), "dist")));
                                                        $shadow->setDirection(PHPExcel_Shared_Drawing::angleToDegrees(self::array_item($outerShdw->attributes(), "dir")));
                                                        $shadow->setAlignment((string) self::array_item($outerShdw->attributes(), "algn"));
                                                        $shadow->getColor()->setRGB(self::array_item($outerShdw->srgbClr->attributes(), "val"));
                                                        $shadow->setAlpha(self::array_item($outerShdw->srgbClr->alpha->attributes(), "val") / 1000);
                                                    }
                                                    $objDrawing->setWorksheet($docSheet);
                                                }
                                            }
                                        }
                                        if ($xmlDrawing->twoCellAnchor) {
                                            foreach ($xmlDrawing->twoCellAnchor as $twoCellAnchor) {
                                                if ($twoCellAnchor->pic->blipFill) {
                                                    $blip = $twoCellAnchor->pic->blipFill->children("http://schemas.openxmlformats.org/drawingml/2006/main")->blip;
                                                    $xfrm = $twoCellAnchor->pic->spPr->children("http://schemas.openxmlformats.org/drawingml/2006/main")->xfrm;
                                                    $outerShdw = $twoCellAnchor->pic->spPr->children("http://schemas.openxmlformats.org/drawingml/2006/main")->effectLst->outerShdw;
                                                    $objDrawing = new PHPExcel_Worksheet_Drawing;
                                                    $objDrawing->setName((string) self::array_item($twoCellAnchor->pic->nvPicPr->cNvPr->attributes(), "name"));
                                                    $objDrawing->setDescription((string) self::array_item($twoCellAnchor->pic->nvPicPr->cNvPr->attributes(), "descr"));
                                                    $objDrawing->setPath("zip://" . PHPExcel_Shared_File::realpath($pFilename) . "#" . $images[(string) self::array_item($blip->attributes("http://schemas.openxmlformats.org/officeDocument/2006/relationships"), "embed")], false);
                                                    $objDrawing->setCoordinates(PHPExcel_Cell::stringFromColumnIndex((string) $twoCellAnchor->from->col) . ($twoCellAnchor->from->row + 1));
                                                    $objDrawing->setOffsetX(PHPExcel_Shared_Drawing::EMUToPixels($twoCellAnchor->from->colOff));
                                                    $objDrawing->setOffsetY(PHPExcel_Shared_Drawing::EMUToPixels($twoCellAnchor->from->rowOff));
                                                    $objDrawing->setResizeProportional(false);
                                                    if ($xfrm) {
                                                        $objDrawing->setWidth(PHPExcel_Shared_Drawing::EMUToPixels(self::array_item($xfrm->ext->attributes(), "cx")));
                                                        $objDrawing->setHeight(PHPExcel_Shared_Drawing::EMUToPixels(self::array_item($xfrm->ext->attributes(), "cy")));
                                                        $objDrawing->setRotation(PHPExcel_Shared_Drawing::angleToDegrees(self::array_item($xfrm->attributes(), "rot")));
                                                    }
                                                    if ($outerShdw) {
                                                        $shadow = $objDrawing->getShadow();
                                                        $shadow->setVisible(true);
                                                        $shadow->setBlurRadius(PHPExcel_Shared_Drawing::EMUTopixels(self::array_item($outerShdw->attributes(), "blurRad")));
                                                        $shadow->setDistance(PHPExcel_Shared_Drawing::EMUTopixels(self::array_item($outerShdw->attributes(), "dist")));
                                                        $shadow->setDirection(PHPExcel_Shared_Drawing::angleToDegrees(self::array_item($outerShdw->attributes(), "dir")));
                                                        $shadow->setAlignment((string) self::array_item($outerShdw->attributes(), "algn"));
                                                        $shadow->getColor()->setRGB(self::array_item($outerShdw->srgbClr->attributes(), "val"));
                                                        $shadow->setAlpha(self::array_item($outerShdw->srgbClr->alpha->attributes(), "val") / 1000);
                                                    }
                                                    $objDrawing->setWorksheet($docSheet);
                                                } elseif (($this->_includeCharts) && ($twoCellAnchor->graphicFrame)) {
                                                    $fromCoordinate = PHPExcel_Cell::stringFromColumnIndex((string) $twoCellAnchor->from->col) . ($twoCellAnchor->from->row + 1);
                                                    $fromOffsetX = PHPExcel_Shared_Drawing::EMUToPixels($twoCellAnchor->from->colOff);
                                                    $fromOffsetY = PHPExcel_Shared_Drawing::EMUToPixels($twoCellAnchor->from->rowOff);
                                                    $toCoordinate = PHPExcel_Cell::stringFromColumnIndex((string) $twoCellAnchor->to->col) . ($twoCellAnchor->to->row + 1);
                                                    $toOffsetX = PHPExcel_Shared_Drawing::EMUToPixels($twoCellAnchor->to->colOff);
                                                    $toOffsetY = PHPExcel_Shared_Drawing::EMUToPixels($twoCellAnchor->to->rowOff);
                                                    $graphic = $twoCellAnchor->graphicFrame->children("http://schemas.openxmlformats.org/drawingml/2006/main")->graphic;
                                                    $chartRef = $graphic->graphicData->children("http://schemas.openxmlformats.org/drawingml/2006/chart")->chart;
                                                    $thisChart = (string) $chartRef->attributes("http://schemas.openxmlformats.org/officeDocument/2006/relationships");

                                                    $chartDetails[$docSheet->getTitle() . '!' . $thisChart] = array(
                                                        'fromCoordinate' => $fromCoordinate,
                                                        'fromOffsetX' => $fromOffsetX,
                                                        'fromOffsetY' => $fromOffsetY,
                                                        'toCoordinate' => $toCoordinate,
                                                        'toOffsetX' => $toOffsetX,
                                                        'toOffsetY' => $toOffsetY,
                                                        'worksheetTitle' => $docSheet->getTitle()
                                                    );
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            if ($xmlWorkbook->definedNames) {
                                foreach ($xmlWorkbook->definedNames->definedName as $definedName) {
                                    $extractedRange = (string)$definedName;
                                    $extractedRange = preg_replace('/\'(\w+)\'\!/', '', $extractedRange);
                                    if (($spos = strpos($extractedRange, '!')) !== false) {
                                        $extractedRange = substr($extractedRange, 0, $spos) . str_replace('$', '', substr($extractedRange, $spos));
                                    } else {
                                        $extractedRange = str_replace('$', '', $extractedRange);
                                    }

                                    if (stripos((string)$definedName, '#REF!') !== false || $extractedRange == '') {
                                        continue;
                                    }

                                    if ((string)$definedName['localSheetId'] != '' && (string)$definedName['localSheetId'] == $sheetId) {
                                        switch ((string)$definedName['name']) {
                                            case '_xlnm._FilterDatabase':
                                                if ((string)$definedName['hidden'] !== '1') {
                                                    $extractedRange = explode(',', $extractedRange);
                                                    foreach ($extractedRange as $range) {
                                                        $autoFilterRange = $range;
                                                        if (strpos($autoFilterRange, ':') !== false) {
                                                            $docSheet->getAutoFilter()->setRange($autoFilterRange);
                                                        }
                                                    }
                                                }
                                                break;
                                            case '_xlnm.Print_Titles':
                                                $extractedRange = explode(',', $extractedRange);
                                                foreach ($extractedRange as $range) {
                                                    $matches = array();
                                                    $range = str_replace('$', '', $range);
                                                    if (preg_match('/!?([A-Z]+)\:([A-Z]+)$/', $range, $matches)) {
                                                        $docSheet->getPageSetup()->setColumnsToRepeatAtLeft(array($matches[1], $matches[2]));
                                                    } elseif (preg_match('/!?(\d+)\:(\d+)$/', $range, $matches)) {
                                                        $docSheet->getPageSetup()->setRowsToRepeatAtTop(array($matches[1], $matches[2]));
                                                    }
                                                }
                                                break;
                                            case '_xlnm.Print_Area':
                                                $rangeSets = explode(',', $extractedRange);
                                                $newRangeSets = array();
                                                foreach ($rangeSets as $rangeSet) {
                                                    $range = explode('!', $rangeSet);
                                                    $rangeSet = isset($range[1]) ? $range[1] : $range[0];
                                                    if (strpos($rangeSet, ':') === false) {
                                                        $rangeSet = $rangeSet . ':' . $rangeSet;
                                                    }
                                                    $newRangeSets[] = str_replace('$', '', $rangeSet);
                                                }
                                                $docSheet->getPageSetup()->setPrintArea(implode(',', $newRangeSets));
                                                break;
                                            default:
                                                $range = explode('!', (string)$definedName);
                                                if (count($range) == 2) {
                                                    $range[0] = str_replace("''", "'", $range[0]);
                                                    $range[0] = str_replace("'", "", $range[0]);
                                                    if ($worksheet = $excel->getSheetByName($range[0])) {
                                                        $excel->addNamedRange(new PHPExcel_NamedRange((string)$definedName['name'], $worksheet, $extractedRange, true, $worksheet));
                                                    }
                                                } else {
                                                    $excel->addNamedRange(new PHPExcel_NamedRange((string)$definedName['name'], $docSheet, $extractedRange, true, $docSheet));
                                                }
                                                break;
                                        }
                                    } elseif ((string)$definedName['localSheetId'] == '') {
                                        $scope = $excel;
                                        $range = explode('!', (string)$definedName);
                                        if (count($range) == 2) {
                                            $range[0] = str_replace("''", "'", $range[0]);
                                            $range[0] = str_replace("'", "", $range[0]);
                                            if ($worksheet = $excel->getSheetByName($range[0])) {
                                                $excel->addNamedRange(new PHPExcel_NamedRange((string)$definedName['name'], $worksheet, $extractedRange, false, $scope));
                                            }
                                        } else {
                                            $excel->addNamedRange(new PHPExcel_NamedRange((string)$definedName['name'], $excel->getSheet(0), $extractedRange, false, $scope));
                                        }
                                    }
                                }
                            }

                            if ($this->_includeCharts && !empty($charts)) {
                                $chartRels = array();
                               // From load method (chart processing)
								// End of load method (ensuring proper closure)
                            foreach ($charts as $chartPath => $chartDetails) {
								$xmlChart = simplexml_load_string(
									$this->securityScan($this->_getFromZipArchive($zip, $chartPath)),
									'SimpleXMLElement',
									PHPExcel_Settings::getLibXmlLoaderOptions() ? PHPExcel_Settings::getLibXmlLoaderOptions() : 0
								);
								$chartRels[$chartDetails['sheet'] . '!' . $chartDetails['id']] = dirname($chartPath) . '/_rels/' . basename($chartPath) . '.rels';
							}

							foreach ($chartDetails as $chartKey => $chartDetail) {
								$xmlChart = simplexml_load_string(
									$this->securityScan($this->_getFromZipArchive($zip, array_search($chartKey, array_keys($charts)))),
									'SimpleXMLElement',
									PHPExcel_Settings::getLibXmlLoaderOptions() ? PHPExcel_Settings::getLibXmlLoaderOptions() : 0
								);
								$xmlChart->registerXPathNamespace('c', 'http://schemas.openxmlformats.org/drawingml/2006/chart');
								$chartTitleElement = $xmlChart->children('http://schemas.openxmlformats.org/drawingml/2006/chart')->title;
								if ($chartTitleElement && !empty($chartTitleElement)) {
									$chartTitle = $this->_parseRichText($chartTitleElement);
								} else {
									$chartTitle = '';
								}
								$objChart = new PHPExcel_Chart(
									'chart' . $chartKey,
									$chartTitle,
									null,
									null,
									true,
									$chartDetail['worksheetTitle']
								);
								$objChart->setTopLeftPosition($chartDetail['fromCoordinate'], $chartDetail['fromOffsetX'], $chartDetail['fromOffsetY']);
								$objChart->setBottomRightPosition($chartDetail['toCoordinate'], $chartDetail['toOffsetX'], $chartDetail['toOffsetY']);
								$excel->getSheetByName($chartDetail['worksheetTitle'])->addChart($objChart);
							}
                        } // Close charts block
                    } // Close sheets block
                } // Close officeDocument relationship
            } // Close rels foreach
        } // Close load method

        $zip->close();
        return $excel;
    } // Ensure load method is fully closed

    /**
     * Read style
     *
     * @param PHPExcel_Style $style
     * @param array $styleData
     */
    private static function _readStyle($style, $styleData)
    {
        if (isset($styleData->numFmt)) {
            if ($styleData->numFmt != 'General' && $styleData->numFmt != '') {
                $style->getNumberFormat()->setFormatCode($styleData->numFmt);
            }
        }
        if (isset($styleData->fill->patternFill->patternType)) {
            $style->getFill()->setFillType((string)$styleData->fill->patternFill->patternType);
            if ($styleData->fill->patternFill->fgColor->rgb) {
                $style->getFill()->getStartColor()->setARGB((string)$styleData->fill->patternFill->fgColor->rgb);
            } else {
                if (isset(self::$_theme) && $styleData->fill->patternFill->fgColor->theme) {
                    $style->getFill()->getStartColor()->setARGB(self::$_theme->getColourByIndex((int)$styleData->fill->patternFill->fgColor->theme));
                }
            }
            if ($styleData->fill->patternFill->bgColor->rgb) {
                $style->getFill()->getEndColor()->setARGB((string)$styleData->fill->patternFill->bgColor->rgb);
            }
        }
        if ($styleData->border) {
            if ($styleData->border->left->borderStyle) {
                $style->getBorders()->getLeft()->setBorderStyle((string)$styleData->border->left->borderStyle);
                if ($styleData->border->left->color->rgb) {
                    $style->getBorders()->getLeft()->getColor()->setARGB((string)$styleData->border->left->color->rgb);
                } else {
                    if (isset(self::$_theme) && $styleData->border->left->color->theme) {
                        $style->getBorders()->getLeft()->getColor()->setARGB(self::$_theme->getColourByIndex((int)$styleData->border->left->color->theme));
                    }
                }
            }
            if ($styleData->border->right->borderStyle) {
                $style->getBorders()->getRight()->setBorderStyle((string)$styleData->border->right->borderStyle);
                if ($styleData->border->right->color->rgb) {
                    $style->getBorders()->getRight()->getColor()->setARGB((string)$styleData->border->right->color->rgb);
                } else {
                    if (isset(self::$_theme) && $styleData->border->right->color->theme) {
                        $style->getBorders()->getRight()->getColor()->setARGB(self::$_theme->getColourByIndex((int)$styleData->border->right->color->theme));
                    }
                }
            }
            if ($styleData->border->top->borderStyle) {
                $style->getBorders()->getTop()->setBorderStyle((string)$styleData->border->top->borderStyle);
                if ($styleData->border->top->color->rgb) {
                    $style->getBorders()->getTop()->getColor()->setARGB((string)$styleData->border->top->color->rgb);
                } else {
                    if (isset(self::$_theme) && $styleData->border->top->color->theme) {
                        $style->getBorders()->getTop()->getColor()->setARGB(self::$_theme->getColourByIndex((int)$styleData->border->top->color->theme));
                    }
                }
            }
            if ($styleData->border->bottom->borderStyle) {
                $style->getBorders()->getBottom()->setBorderStyle((string)$styleData->border->bottom->borderStyle);
                if ($styleData->border->bottom->color->rgb) {
                    $style->getBorders()->getBottom()->getColor()->setARGB((string)$styleData->border->bottom->color->rgb);
                } else {
                    if (isset(self::$_theme) && $styleData->border->bottom->color->theme) {
                        $style->getBorders()->getBottom()->getColor()->setARGB(self::$_theme->getColourByIndex((int)$styleData->border->bottom->color->theme));
                    }
                }
            }
            if ($styleData->border->diagonal->borderStyle) {
                $style->getBorders()->getDiagonal()->setBorderStyle((string)$styleData->border->diagonal->borderStyle);
                if ($styleData->border->diagonal->color->rgb) {
                    $style->getBorders()->getDiagonal()->getColor()->setARGB((string)$styleData->border->diagonal->color->rgb);
                } else {
                    if (isset(self::$_theme) && $styleData->border->diagonal->color->theme) {
                        $style->getBorders()->getDiagonal()->getColor()->setARGB(self::$_theme->getColourByIndex((int)$styleData->border->diagonal->color->theme));
                    }
                }
            }
            if ($styleData->border['diagonalDirection']) {
                $style->getBorders()->setDiagonalDirection((string)$styleData->border['diagonalDirection']);
            }
        }
        if ($styleData->alignment) {
            if ($styleData->alignment['horizontal']) {
                $style->getAlignment()->setHorizontal((string)$styleData->alignment['horizontal']);
            }
            if ($styleData->alignment['vertical']) {
                $style->getAlignment()->setVertical((string)$styleData->alignment['vertical']);
            }
            if ($styleData->alignment['textRotation']) {
                $style->getAlignment()->setTextRotation(intval($styleData->alignment['textRotation']));
            }
            if ($styleData->alignment['wrapText']) {
                $style->getAlignment()->setWrapText(self::boolean((string)$styleData->alignment['wrapText']));
            }
            if ($styleData->alignment['shrinkToFit']) {
                $style->getAlignment()->setShrinkToFit(self::boolean((string)$styleData->alignment['shrinkToFit']));
            }
            if ($styleData->alignment['indent']) {
                $style->getAlignment()->setIndent(intval($styleData->alignment['indent']));
            }
        }
        if ($styleData->font) {
            if ($styleData->font->name['val']) {
                $style->getFont()->setName((string)$styleData->font->name['val']);
            }
            if ($styleData->font->sz['val']) {
                $style->getFont()->setSize(floatval($styleData->font->sz['val']));
            }
            if ($styleData->font->b['val']) {
                $style->getFont()->setBold(self::boolean((string)$styleData->font->b['val']));
            }
            if ($styleData->font->i['val']) {
                $style->getFont()->setItalic(self::boolean((string)$styleData->font->i['val']));
            }
            if ($styleData->font->strike['val']) {
                $style->getFont()->setStrikethrough(self::boolean((string)$styleData->font->strike['val']));
            }
            if ($styleData->font->u['val']) {
                $style->getFont()->setUnderline((string)$styleData->font->u['val']);
            }
            if ($styleData->font->color->rgb) {
                $style->getFont()->getColor()->setARGB((string)$styleData->font->color->rgb);
            } else {
                if (isset(self::$_theme) && $styleData->font->color->theme) {
                    $style->getFont()->getColor()->setARGB(self::$_theme->getColourByIndex((int)$styleData->font->color->theme));
                }
            }
        }
        if ($styleData->protection) {
            if (isset($styleData->protection['locked'])) {
                $style->getProtection()->setLocked((string)$styleData->protection['locked']);
            }
            if (isset($styleData->protection['hidden'])) {
                $style->getProtection()->setHidden((string)$styleData->protection['hidden']);
            }
        }
        if ($styleData->quotePrefix) {
            $style->setQuotePrefix(true);
        }
    }


										
										/**
										 * Parse Rich Text
										 *
										 * @param SimpleXMLElement $is
										 * @return PHPExcel_RichText
										 */
										private function _parseRichText($is = null)
										{
											$value = new PHPExcel_RichText();

											if (isset($is->t)) {
												$value->createText(PHPExcel_Shared_String::ControlCharacterOOXML2PHP((string) $is->t));
											} else {
												if (is_object($is)) {
													foreach ($is->r as $run) {
														if (!isset($run->rPr)) {
															$objText = $value->createText(PHPExcel_Shared_String::ControlCharacterOOXML2PHP((string) $run->t));
														} else {
															$objText = $value->createTextRun(PHPExcel_Shared_String::ControlCharacterOOXML2PHP((string) $run->t));
															if (isset($run->rPr->rFont['val'])) {
																$objText->getFont()->setName((string) $run->rPr->rFont['val']);
															}
															if (isset($run->rPr->sz['val'])) {
																$objText->getFont()->setSize(floatval($run->rPr->sz['val']));
															}
															if (isset($run->rPr->color->rgb)) {
																$objText->getFont()->getColor()->setARGB((string) $run->rPr->color->rgb);
															} else {
																if (isset(self::$_theme) && isset($run->rPr->color->theme)) {
																	$objText->getFont()->getColor()->setARGB(self::$_theme->getColourByIndex((int) $run->rPr->color->theme));
																}
															}
															if (isset($run->rPr->b['val']) && self::boolean((string) $run->rPr->b['val'])) {
																$objText->getFont()->setBold(true);
															}
															if (isset($run->rPr->i['val']) && self::boolean((string) $run->rPr->i['val'])) {
																$objText->getFont()->setItalic(true);
															}
															if (isset($run->rPr->u['val'])) {
																$objText->getFont()->setUnderline((string) $run->rPr->u['val']);
															}
															if (isset($run->rPr->strike['val']) && self::boolean((string) $run->rPr->strike['val'])) {
																$objText->getFont()->setStrikethrough(true);
															}
														}
													}
												}
											}

											return $value;
										}

										/**
										 * Read Ribbon
										 *
										 * @param PHPExcel $excel
										 * @param string $customUITarget
										 * @param ZipArchive $zip
										 */
										private function _readRibbon($excel, $customUITarget, $zip)
										{
											$baseDir = dirname($customUITarget);
											$nameCustomUI = basename($customUITarget);
											$localRibbon = $this->_getFromZipArchive($zip, $customUITarget);
											$customUIImagesNames = array();
											$customUIImagesBinaries = array();

											if ($zip->locateName($baseDir . '/_rels/' . $nameCustomUI . '.rels')) {
												$relationship = simplexml_load_string(
													$this->securityScan($this->_getFromZipArchive($zip, $baseDir . '/_rels/' . $nameCustomUI . '.rels')),
													'SimpleXMLElement',
													PHPExcel_Settings::getLibXmlLoaderOptions() ?: 0
												);
												foreach ($relationship->Relationship as $rel) {
													switch ($rel["Type"]) {
														case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/image":
															$customUIImagesNames[(string) $rel['Id']] = (string) $rel['Target'];
															$customUIImagesBinaries[(string) $rel['Target']] = $this->_getFromZipArchive($zip, $baseDir . '/' . (string) $rel['Target']);
															break;
													}
												}
											}

											if ($localRibbon) {
												$excel->setRibbonXMLData($customUITarget, $localRibbon);
												if (count($customUIImagesNames) > 0 && count($customUIImagesBinaries) > 0) {
													$excel->setRibbonBinObjects($customUIImagesNames, $customUIImagesBinaries);
												} else {
													$excel->setRibbonBinObjects(null, null);
												}
											} else {
												$excel->setRibbonXMLData(null, null);
												$excel->setRibbonBinObjects(null, null);
											}
										}
									
										
										/**
										 * Get array item
										 *
										 * @param array $array
										 * @param string $key
										 * @return mixed
										 */
										private static function array_item($array, $key = 0)
										{
											return (isset($array[$key]) ? $array[$key] : null);
										}

										/**
										 * Convert style string to array
										 *
										 * @param string $style
										 * @return array
										 */
										private static function toCSSArray($style)
										{
											$style = str_replace(array("\r", "\n"), '', $style);
											$temp = explode(';', $style);
											$styleArray = array();
											foreach ($temp as $item) {
												$item = explode(':', $item);
												if (strpos($item[1], 'px') !== false) {
													$item[1] = str_replace('px', '', $item[1]);
												}
												if (strpos($item[1], 'pt') !== false) {
													$item[1] = str_replace('pt', '', $item[1]);
													$item[1] = PHPExcel_Shared_Drawing::pointsToPixels(floatval($item[1]));
												}
												if (strpos($item[1], 'in') !== false) {
													$item[1] = str_replace('in', '', $item[1]);
													$item[1] = PHPExcel_Shared_Drawing::inchesToPixels(floatval($item[1]));
												}
												$styleArray[strtolower(trim($item[0]))] = trim($item[1]);
											}
											return $styleArray;
										}

										/**
										 * Add directory path
										 *
										 * @param string $base
										 * @param string $path
										 * @return string
										 */
										private static function dir_add($base, $path)
										{
											return preg_replace('~[^/]+/\.\./~', '/', dirname($base) . "/" . $path);
										}

										/**
										 * Convert value to boolean
										 *
										 * @param mixed $value
										 * @return boolean
										 */
										private static function boolean($value = null)
										{
											if (is_object($value)) {
												$value = (string) $value;
											}
											if (is_numeric($value)) {
												return (bool) $value;
											}
											return ($value === 'true' || $value === 'TRUE');
										}
									}
									?>