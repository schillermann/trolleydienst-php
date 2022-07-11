<?php
namespace App\Models;

class Profile {
    /**
     * Profile constructor.
     * @param int $id_user
     * @param array $data With keys: name, email, phone, mobile, congregation, language, note_user
     */
    function __construct(int $id_user, array $data) {
        $this->id_user = $id_user;
        $this->username = (isset($data['username']))? $data['username'] : '';
        $this->firstName = (isset($data['first_name']))? $data['first_name'] : '';
        $this->lastName = (isset($data['last_name']))? $data['last_name'] : '';
        $this->email = (isset($data['email']))? $data['email'] : '';
        $this->phone = (isset($data['phone']))? $data['phone'] : '';
        $this->mobile = (isset($data['mobile']))? $data['mobile'] : '';
        $this->congregation = (isset($data['congregation']))? $data['congregation'] : '';
        $this->language = (isset($data['language']))? $data['language'] : '';
        $this->note_user = (isset($data['note_user']))? $data['note_user'] : '';
    }

    function  get_id_user(): int {
        return $this->id_user;
    }

    function get_username(): string {
        return $this->username;
    }
    
    function get_firstName(): string {
        return $this->firstName;
    }

    function get_lastName(): string {
        return $this->lastName;
    }

    function get_email(): string {
        return $this->email;
    }

    function get_phone(): string {
        return $this->phone;
    }

    function get_mobile(): string {
        return $this->mobile;
    }

    function get_congregation(): string {
        return $this->congregation;
    }

    function get_language(): string {
        return $this->language;
    }

    function get_note_user(): string {
        return $this->note_user;
    }

    protected $id_user, $firstName, $lastName, $email, $phone, $mobile, $congregation, $language, $note_user;
}