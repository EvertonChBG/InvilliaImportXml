<?php

namespace App\Repositories;

use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\Import;
use App\Models\People;
use App\Models\Shiporder;
use App\Models\ShiporderItem;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Stream;
use Prewk\XmlStringStreamer\Parser;

class ImportXmlRepository
{
    /**
     * Accumulates errors during execution
     * @var array
     */
    private array $aErrors = [];

    /**
     * Model
     * @var Import
     */
    private Import $oImport;

    /**
     * File when importing
     * @var File|null
     */
    private File $oFile;

    /**
     * ImportXmlRepository constructor.
     */
    public function __construct()
    {
    }


    public function setFile(File $oFile)
    {
        $this->oFile = $oFile;
    }

    /**
     * Return model
     * @return Import
     */
    public function getImport()
    {
        return $this->oImport;
    }

    /**
     * Validate file
     * @param string $sPathFile
     * @return bool
     * @throws \Exception
     */
    private function validateFile(string $sPathFile)
    {
        if (empty($this->oFile)) {
            throw new \Exception('File not found!');
        }

        libxml_use_internal_errors(false);

        try {

            $objDom = new \DOMDocument();
            $objDom->load(Storage::path($sPathFile),LIBXML_NOWARNING);

            $objDom->schemaValidate(public_path('xsd/validationRules.xsd'));

        } catch (\Exception $oError) {
            session()->put('errors',libxml_get_errors());;
        }

        return true;
    }

    /**
     * Upload the file and save the import to the bank
     * @return bool
     * @throws \Exception
     */
    public function upload()
    {
        if (empty($this->oFile)) {
            throw new \Exception('File not found!');
        }

        $sPathFile = Storage::putFileAs(
            "xmlFiles",
            $this->oFile,
            uniqid() . ".xml");

        if (!$sErrorValid = $this->validateFile($sPathFile)) {
            throw new \Exception($sErrorValid);
        }

        $oImport = new Import();
        $oImport->file_path = $sPathFile;
        $oImport->size = $this->oFile->getSize();
        $oImport->async = isset(request()->async) ? true : false;

        $oImport->save();
        $this->oImport = $oImport;

        return true;
    }

    /**
     * Processes the file in the bank asynchronously or synchronously
     * @return bool
     * @throws \Exception
     */
    public function processFile()
    {
        if (empty($this->oImport)) {
            $aFilesToImport = (new Import())->scopeAsyncUnprocessed()->get();
        } else {
            $aFilesToImport = new Collection([$this->oImport]);
        }

        if (count($aFilesToImport) < 1) {
            throw new \Exception('File(s) not Found!');
        }

        session()->put('errors',$this->aErrors);

        $aFilesToImport->map(function ($oImports) {

            $sPathStorage = Storage::path($oImports->file_path);

            $oStream = new Stream\File($sPathStorage,1024);
            $oParser = new Parser\StringWalker();

            $oStreamer = new XmlStringStreamer($oParser,$oStream);

            while ($oNode = $oStreamer->getNode()) {

                try {
                    $oXmlNode = simplexml_load_string($oNode);

                    switch ($oXmlNode) {

                        case isset($oXmlNode->personid):
                            $this->importPeoples($oXmlNode);
                            break;
                        case isset($oXmlNode->orderid):
                            $this->importShiporders($oXmlNode);
                            break;
                        default;
                            throw new \Exception('File format is invalid!',400);
                            break;
                    }

                } catch (\Exception $oError) {
                    $this->aErrors[] = $oError->getMessage();
                }
            }

            $oImports->date_processed = now();
            $oImports->save();
        });

        //  Saves the errors found to show in the view
        if (count($this->aErrors) > 0) {
            session()->put('errors',$this->aErrors);
        }

        return true;
    }

    /**
     * Saves model of People in the bank
     * @param \SimpleXMLElement $oXmlNode
     * @return People
     */
    private function importPeoples(\SimpleXMLElement $oXmlNode)
    {
        $oPhone = json_encode($oXmlNode->phones->phone);
        $aPhone = json_decode($oPhone,true);

        $oNewPeople = new People();
        $oNewPeople->id = $oXmlNode->personid;
        $oNewPeople->name = $oXmlNode->personname;
        $oNewPeople->phone = $aPhone;
        $oNewPeople->save();

        return $oNewPeople;
    }

    /**
     * Saves model of Shiporder in the bank
     * @param \SimpleXMLElement $oXmlNode
     * @return Shiporder
     */
    private function importShiporders(\SimpleXMLElement $oXmlNode)
    {
        $oShipto = json_encode($oXmlNode->shipto);
        $aShipto = json_decode($oShipto,true);

        $oNewShiporder = new Shiporder();
        $oNewShiporder->id = $oXmlNode->orderid;
        $oNewShiporder->person_id = $oXmlNode->orderperson;
        $oNewShiporder->shipto = $aShipto;
        $oNewShiporder->save();

        foreach ($oXmlNode->items as $oItemList) {

            foreach ($oItemList as $oItem) {

                $oItem = json_encode($oItem);
                $oItem = json_decode($oItem);

                $oNewShiporderItem = new ShiporderItem();
                $oNewShiporderItem->title = $oItem->title;
                $oNewShiporderItem->note = $oItem->note;
                $oNewShiporderItem->quantity = $oItem->quantity;
                $oNewShiporderItem->price = $oItem->price;
                $oNewShiporderItem->shiporder_id = $oNewShiporder->id;
                $oNewShiporderItem->save();
            }
        }

        return $oNewShiporder;
    }
}
