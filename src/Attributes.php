<?php

namespace FreezyBee\MojeId;

use Nette\Object;

class Attributes extends Object
{
    const SIMPLE = 'simple';
    const FULL = 'full';

    public static $fields = [
        'fullname' => [
            'scheme' => 'http://axschema.org/namePerson',
            'text' => 'Celé jméno',
            'required' => false,
            'simple' => true
        ],
        'firstname' => [
            'scheme' => 'http://axschema.org/namePerson/first',
            'text' => 'Jméno',
            'required' => true,
            'simple' => true
        ],
        'lastname' => [
            'scheme' => 'http://axschema.org/namePerson/last',
            'text' => 'Příjmení',
            'required' => true,
            'simple' => true
        ],
        'nick' => [
            'scheme' => 'http://axschema.org/namePerson/friendly',
            'text' => 'Přezdívka',
            'required' => false,
            'simple' => true
        ],
        'company' => [
            'scheme' => 'http://axschema.org/company/name',
            'text' => 'Jméno společnosti',
            'required' => false,
            'simple' => true
        ],
        'h_address' => [
            'scheme' => 'http://axschema.org/contact/postalAddress/home',
            'text' => 'Domácí adresa – Ulice',
            'required' => true
        ],
        'h_address2' => [
            'scheme' => 'http://axschema.org/contact/postalAddressAdditional/home',
            'text' => 'Domácí adresa – Ulice2',
            'required' => false,
            'simple' => true
        ],
        'h_address3' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/main/street3',
            'text' => 'Domácí adresa – Ulice3',
            'required' => false
        ],
        'h_city' => [
            'scheme' => 'http://axschema.org/contact/city/home',
            'text' => 'Domácí adresa – Město',
            'required' => true,
            'simple' => true
        ],
        'h_state' => [
            'scheme' => 'http://axschema.org/contact/state/home',
            'text' => 'Domácí adresa – Stát',
            'required' => true,
            'simple' => true
        ],
        'h_country' => [
            'scheme' => 'http://axschema.org/contact/country/home',
            'text' => 'Domácí adresa – Země',
            'required' => true,
            'simple' => true
        ],
        'h_postcode' => [
            'scheme' => 'http://axschema.org/contact/postalCode/home',
            'text' => 'Domácí adresa – PSČ',
            'required' => true,
            'simple' => true
        ],
        'b_address' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/bill/street',
            'text' => 'Faktur. adresa – Ulice',
            'required' => false
        ],
        'b_address2' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/bill/street2',
            'text' => 'Faktur. adresa – Ulice2',
            'required' => false
        ],
        'b_address3' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/bill/street3',
            'text' => 'Faktur. adresa – Ulice3',
            'required' => false
        ],
        'b_city' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/bill/city',
            'text' => 'Faktur. adresa – Město',
            'required' => false
        ],
        'b_state' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/bill/sp',
            'text' => 'Faktur. adresa – Stát',
            'required' => false
        ],
        'b_country' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/bill/cc',
            'text' => 'Faktur. adresa – Země',
            'required' => false
        ],
        'b_postcode' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/bill/pc',
            'text' => 'Faktur. adresa – PSČ',
            'required' => false
        ],
        's_address' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/ship/street',
            'text' => 'Doruč. adresa – Ulice',
            'required' => false
        ],
        's_address2' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/ship/street2',
            'text' => 'Doruč. adresa – Ulice2',
            'required' => false
        ],
        's_address3' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/ship/street3',
            'text' => 'Doruč. adresa – Ulice3',
            'required' => false
        ],
        's_city' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/ship/city',
            'text' => 'Doruč. adresa – Město',
            'required' => false
        ],
        's_state' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/ship/sp',
            'text' => 'Doruč. adresa – Stát',
            'required' => false
        ],
        's_country' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/ship/cc',
            'text' => 'Doruč. adresa – Země',
            'required' => false
        ],
        's_postcode' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/ship/pc',
            'text' => 'Doruč. adresa – PSČ',
            'required' => false
        ],
        'm_address' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/mail/street',
            'text' => 'Koresp. adresa – Ulice',
            'required' => false
        ],
        'm_address2' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/mail/street2',
            'text' => 'Koresp. adresa – Ulice2',
            'required' => false
        ],
        'm_address3' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/mail/street3',
            'text' => 'Koresp. adresa – Ulice3',
            'required' => false
        ],
        'm_city' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/mail/city',
            'text' => 'Koresp. adresa – Město',
            'required' => false
        ],
        'm_state' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/mail/sp',
            'text' => 'Koresp. adresa – Stát',
            'required' => false
        ],
        'm_country' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/mail/cc',
            'text' => 'Koresp. adresa – Země',
            'required' => false
        ],
        'm_postcode' => [
            'scheme' => 'http://specs.nic.cz/attr/addr/mail/pc',
            'text' => 'Koresp. adresa – PSČ',
            'required' => false
        ],
        'phone' => [
            'scheme' => 'http://axschema.org/contact/phone/default',
            'text' => 'Telefon – Hlavní',
            'required' => false,
            'simple' => true
        ],
        'phone_home' => [
            'scheme' => 'http://axschema.org/contact/phone/home',
            'text' => 'Telefon – Domácí',
            'required' => false
        ],
        'phone_work' => [
            'scheme' => 'http://axschema.org/contact/phone/business',
            'text' => 'Telefon – Pracovní',
            'required' => false
        ],
        'phone_mobile' => [
            'scheme' => 'http://axschema.org/contact/phone/cell',
            'text' => 'Telefon – Mobil',
            'required' => false,
            'simple' => true
        ],
        'fax' => [
            'scheme' => 'http://axschema.org/contact/phone/fax',
            'text' => 'Telefon – Fax',
            'required' => false
        ],
        'email' => [
            'scheme' => 'http://axschema.org/contact/email',
            'text' => 'Email – Hlavní',
            'required' => false,
            'simple' => true
        ],
        'email2' => [
            'scheme' => 'http://specs.nic.cz/attr/email/notify',
            'text' => 'Email – Notifikační',
            'required' => false
        ],
        'email3' => [
            'scheme' => 'http://specs.nic.cz/attr/email/next',
            'text' => 'Email – Další',
            'required' => false
        ],
        'url' => [
            'scheme' => 'http://axschema.org/contact/web/default',
            'text' => 'URL – Hlavní',
            'required' => false,
            'simple' => true
        ],
        'blog' => [
            'scheme' => 'http://axschema.org/contact/web/blog',
            'text' => 'URL – Blog',
            'required' => false
        ],
        'url2' => [
            'scheme' => 'http://specs.nic.cz/attr/url/personal',
            'text' => 'URL – Osobní',
            'required' => false
        ],
        'url3' => [
            'scheme' => 'http://specs.nic.cz/attr/url/work',
            'text' => 'URL – Pracovní',
            'required' => false
        ],
        'rss' => [
            'scheme' => 'http://specs.nic.cz/attr/url/rss',
            'text' => 'URL – RSS',
            'required' => false
        ],
        'fb' => [
            'scheme' => 'http://specs.nic.cz/attr/url/facebook',
            'text' => 'URL – Facebook',
            'required' => false
        ],
        'twitter' => [
            'scheme' => 'http://specs.nic.cz/attr/url/twitter',
            'text' => 'URL – Twitter',
            'required' => false
        ],
        'linkedin' => [
            'scheme' => 'http://specs.nic.cz/attr/url/linkedin',
            'text' => 'URL – LinkedIN',
            'required' => false
        ],
        'icq' => [
            'scheme' => 'http://axschema.org/contact/IM/ICQ',
            'text' => 'IM -ICQ',
            'required' => false
        ],
        'jabber' => [
            'scheme' => 'http://axschema.org/contact/IM/Jabber',
            'text' => 'IM – Jabber',
            'required' => false
        ],
        'skype' => [
            'scheme' => 'http://axschema.org/contact/IM/Skype',
            'text' => 'IM – Skype',
            'required' => false
        ],
        'gtalk' => [
            'scheme' => 'http://specs.nic.cz/attr/im/google_talk',
            'text' => 'IM – Google Talk',
            'required' => false
        ],
        'wlive' => [
            'scheme' => 'http://specs.nic.cz/attr/im/windows_live',
            'text' => 'IM – Windows Live',
            'required' => false
        ],
        'vat_id' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/ident/vat_id',
            'text' => 'Identifikátor - ICO',
            'required' => false
        ],
        'vat' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/vat',
            'text' => 'Identifikátor - DIC',
            'required' => false
        ],
        'op' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/ident/card',
            'text' => 'Identifikátor – OP',
            'required' => false
        ],
        'pas' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/ident/pass',
            'text' => 'Identifikátor - PAS',
            'required' => false
        ],
        'mpsv' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/ident/ssn',
            'text' => 'Identifikátor - MPSV',
            'required' => false
        ],
        'student' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/student',
            'text' => 'Příznak - Student',
            'required' => false,
            'simple' => true
        ],
        'valid' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/valid',
            'text' => 'Příznak – Validace',
            'required' => false,
            'simple' => true
        ],
        'status' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/status',
            'text' => 'Stav účtu',
            'required' => false,
            'simple' => true
        ],
        'adult' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/adult',
            'text' => 'Příznak – Starší 18 let',
            'required' => false,
            'simple' => true
        ],
        'image' => [
            'scheme' => 'http://specs.nic.cz/attr/contact/image',
            'text' => 'Obrázek (base64)',
            'required' => false,
            'simple' => true
        ]
    ];

    public static function getFields($type)
    {
        if ($type === self::FULL) {
            return self::$fields;
        } elseif ($type === self::SIMPLE) {
            $tmp = [];
            foreach(self::$fields as $id => $field) {
                if (isset($field['simple'])) {
                    $tmp[$id] = $field;
                }
            }
            return $tmp;

        } else {
            return [];
        }
    }
}
