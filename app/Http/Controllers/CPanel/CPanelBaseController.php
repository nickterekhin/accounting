<?php


namespace App\Http\Controllers\CPanel;


use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AddressType;
use App\Models\ModelProvider\IAddresses;
use App\Models\ModelProvider\IAddressTypes;
use Illuminate\Http\Request;

abstract class CPanelBaseController extends Controller
{

    /**
     * @var IAddresses
     */
    protected $_address;
    /**
     * @var IAddressTypes
     */
    protected $_address_types;


    function saveAddress(Request $request, $type_name,$objectId)
    {
        /** @var AddressType $type_address */
        $type_address = $this->_address_types->getByTypeName($type_name);
        $address_options = array(
            'TypeId'=>$type_address->getId(),
            'ObjectId'=>$objectId,
            'City' => $request->get('City'),
            'Street1'=> $request->get('Street1'),
            'Street2'=> $request->get('Street2'),
            'Zip'=> $request->get('ZipCode'),
            'Active'=>1
        );
        return $this->_address->create($address_options);

    }
    function updateAddress(Request $request,$type_name,$objectId)
    {
        /** @var Address $address */
        $address = $this->_address->getByTypeNameAndObjectId($type_name,$objectId);
        $address->setCity($request->get('City'));
        $address->setStreet1($request->get('Street1'));
        $address->setStreet2($request->get('Street2'));
        $address->setZip($request->get('ZipCode'));
        $this->_address->update($address);
    }
    private function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
    function createSlug($str)
    {
        $str = $this->rus2translit($str);
        $str = strtolower($str);
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        $str = trim($str, "-");
        return $str;
    }

}